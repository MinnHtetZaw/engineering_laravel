<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Asset;
use App\Models\Building;
use App\Models\Maintenance;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
// use Intervention\Image\Image;
use App\Http\Requests\TestRequest;

use App\Models\RequestMaintenance;

use Illuminate\Support\Facades\Redis;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\ReportRequestMaintenance;
use Illuminate\Support\Facades\Validator;
use App\Models\ReportRequestMinatenanceFile;
use App\Http\Resources\ReportRequestMaintenanceResource;

class MaintenanceController extends Controller
{
    //
    public function getMaintenanceData()
    {
        $maintenanceData = Maintenance::all();

        return response()->json(['data' => $maintenanceData]);
    }

    public function storeMaintenance(Request $request)
    {

        $maintenanceName = 'Maintenance_' . uniqid() . "." . $request->file('file')->extension();
        $request->file('file')->move(public_path() . '/maintenance/', $maintenanceName);

        $maintenanceData = new Maintenance();
        $maintenanceData->last_maintenance_date = $request->last_maintenance_date;
        $maintenanceData->next_maintenance_date = $request->next_maintenance_date;
        $maintenanceData->type = $request->type;
        $maintenanceData->remark = $request->remark;
        $maintenanceData->person = $request->person;
        $maintenanceData->maintenance_docs = $maintenanceName;
        $maintenanceData->asset_id = $request->asset_id;
        $maintenanceData->save();

        $asset = Asset::find($request->asset_id);
        $asset->last_maintenance_date = $request->last_maintenance_date;
        $asset->next_maintenance_date =  $request->next_maintenance_date;
        $asset->save();

        return response()->json(['success' => 'Successfully Added']);
    }

    public function getRequestList()
    {
        $requestLists = RequestMaintenance::with('asset:id,name,room_id', 'asset.room:id,room_number', 'employee:id,name')->get();

        return response()->json(['requests' => $requestLists]);
    }

    public function getBuildingRoomData()
    {
        $buildings =  Building::all();
        $room = Room::with('assetrequest')->get();
        return response()->json(['room' => $room, 'buildings' => $buildings]);
    }
    public function storeRequest(Request $request)
    {
        RequestMaintenance::create([
            'request_no' => $request->request_no,
            'requset_date' => $request->requset_date,
            'due_date' => $request->due_date,
            'condition' => $request->condition,
            'requirement_remark' => $request->remark,
            'asset_id' => $request->asset_id,
            'finish_status' => 0,
        ]);

        return response()->json(['success' => 'success']);
    }

    public function getRequestDetail($id)
    {
        $data = RequestMaintenance::find($id);
        $asset = Asset::select('name', 'room_id')->find($data->asset_id);
        $room = Room::select('room_number', 'building_id')->find($asset->room_id);
        $building = Building::select('name')->find($room->building_id);

        return response()->json(['request' => $data, 'asset' => $asset, 'room' => $room, 'building' => $building]);
    }

    public function approveRequest(Request $request)
    {
        $data = RequestMaintenance::find($request->id);
        $data->employee_id = $request->employee_id;
        $data->save();
        return response()->json(['success' => 'success']);
    }

    public function storeReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'finished_date' => 'required',
            'report_description' => 'required',
            'checked_by' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendFailResponse("Wrong!!!");
        }

        $requestMaintenance = RequestMaintenance::find($request->request_id);
        $dueDate = Carbon::parse($requestMaintenance->due_date);
        $finish_time = Carbon::parse($request->finished_date);

        $result = $finish_time->diffInDays($dueDate, false);

        if ($request->progress == 100 || $request->complete == 1) {
            $requestMaintenance->finish_status = 1;
            $requestMaintenance->save();
            if ($result == 0) {
                $per_status = 1;
                $perfor = "on time";
            } elseif ($result > 0) {
                $per_status = 2;
                $perfor = "early -" . $result . "days";
            } else {
                $per_status = 3;
                $results = $result * -1;
                $perfor = "late -" . $results . "days";
            }
        } elseif ($request->progress < 100 && $result < 0) {
            $per_status = 3;
            $results = $result * -1;
            $perfor = "late -" . $requestMaintenance->due_date;
        } else {

            $per_status = 0;

            $perfor = "in progress";
        }

        $photo_arr = [];
        $video_arr =[];

        if ($request->photo !=null)
        {
            foreach ($request->photo as $eachpho) {

               $image = str_replace(' ', '+', $eachpho);

               $imageName = 'report_maintenance-'.Str::random(10).'.png';
               $folderPath = "report_maintenance/photo/";
               $file = $folderPath.$imageName;
               $base64_decode =  base64_decode($image);
               $resizedImage =  Image::make($base64_decode)->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $resizedImage->save($file, 60);
                $photo_arr[] = $imageName;
            }
        }

        if($request->video !=null){

            foreach($request->video as $eachvideo)
            {
                $video = str_replace(' ', '+', $eachvideo);

                $videoName = 'report_maintenance-'.Str::random(10).'.mp4';
                $folderPath = "report_maintenance/video/";
                $file = $folderPath.$videoName;
                 file_put_contents($file,base64_decode($video));
                 $video_arr[] = $videoName;
            }
        }

            if($request->photo != null && $request->video != null)
            {
                $file_count = count($photo_arr) + count($video_arr);
            }elseif($request->photo == null && $request->video != null)
            {
                $file_count = count($video_arr);
            }
            else
            {
                $file_count = count($photo_arr);
            }


        $progresss = $request->progress . "%";
        $report_request_maintenance = ReportRequestMaintenance::create([
            'request_maintenance_id' => $request->request_id,
            'report_description' => $request->report_description,
            'finished_date' => $request->finished_date,
            'file_count' => $file_count ?? 0,
            'checked_by' => $request->checked_by,
            'total_stock_qty' => $total_qty ?? 0,
            'progress' => $progresss,
            'performance' => $perfor, //
            'performance_status' => $per_status,
        ]);

            if($request->photo !=null){
                ReportRequestMinatenanceFile::create([
                    'report_req_maintain_id' => $report_request_maintenance->id,
                    'file_type' => 1,
                    'file' => json_encode($photo_arr),
                ]);
            }
            if($request->video !=null)
            {
                ReportRequestMinatenanceFile::create([
                    'report_req_maintain_id' => $report_request_maintenance->id,
                    'file_type' => 2,
                    'file' => json_encode($video_arr),
                ]);
            }

        return new ReportRequestMaintenanceResource($report_request_maintenance);
    }

    public function getList(RequestMaintenance $reqMaintain)
    {
        $reports =$reqMaintain->reports()->get();

        return ReportRequestMaintenanceResource::collection($reports);
    }

    public function getRequestListByEmployeeID(Request $request)
    {
        $requestLists = RequestMaintenance::where('employee_id',$request->employee_id)->with('asset:id,name,room_id', 'asset.room:id,room_number', 'employee:id,name')->get();

        return response()->json(['requests' => $requestLists]);
    }
}
