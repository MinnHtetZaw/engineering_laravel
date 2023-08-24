<?php

namespace App\Http\Controllers\Mobile;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Employee;
use App\Models\PhaseTask;
use App\Models\ReportTask;
use Illuminate\Support\Str;
use App\Models\ProjectPhase;
use Illuminate\Http\Request;
use App\Models\ReportTaskFile;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ReportTaskResource;

class MobileProjectController extends Controller
{
    //

    public function index()
    {
        $projects = Project::with('phases')->get();
        $user = User::all();
        return response()->json([
            'project' => $projects,
            'user' => $user,
        ],200);
    }

    public function getProjectForInv(Employee $employee)
    {
        $projects = Project::withWhereHas('phases',function ($query) use($employee){
                            $query->where('user_id',$employee->user_id);
        })->get();

        $user = User::all();
        return response()->json([
            'project' => $projects,
            'user' => $user,
        ],200);
    }

    public function getProjectListByid(Employee $employee)
    {

            $phases  =  ProjectPhase::where('user_id',$employee->user_id)->with('project:id,name,project_contact_person,phone,email','phasetasks')->get();

         return response()->json(['phases'=>$phases]);
    }

    public function getAllListByID(Employee $employee)
    {

        $data=ReportTask::with('task.project_phase.project')->whereHas('task.project_phase.project',function ($query) use($employee){
           $query->where('user_id',$employee->user_id);
        })->orderByDesc('finished_date')->get();
        return response()->json($data);
    }


    public function storeReportTask(Request $request)
    {
            $validator = Validator::make($request->all(), [
                        'finished_date' => 'required',
                        'report_description' => 'required',
                        'checked_by' => 'required',
                    ]);
                    if ($validator->fails()) {
                        return $this->sendFailResponse("Wrong!!!");
                    }

                    $task = PhaseTask::find($request->phase_task_id);
                    $end_date = Carbon::parse($task->end_date);
                    $finish_time = Carbon::parse($request->finished_date);


            $result = $finish_time->diffInDays($end_date, false);

            if($request->progress == 100 || $request->complete == 1)
            {
            $task->complete = 1;
            $task->status = 1;
            $task->progress = $request->progress;
            $task->save();
                    if($result == 0)
                    {
                        $per_status = 1;
                        $perfor = "on time";
                    }
                    elseif($result > 0)
                    {
                        $per_status = 2;
                        $perfor = "early -".$result."days";
                    }
                    else
                    {
                        $per_status = 3;
                        $results = $result * -1;
                        $perfor = "late -".$results."days";
                    }
            }
            elseif($request->progress < 100 && $result < 0)
            {
                $task->progress = $request->progress;
                $task->save();
                $per_status = 3;
                $results = $result * -1;
                $perfor = "late -".$task->end_date;
            }
            else{
                $task->progress = $request->progress;
                $task->save();
                $per_status = 0;

                $perfor = "in progress";
            }

            $photo_arr = [];
            $video_arr =[];

            if ($request->photo !=null)
            {
                foreach ($request->photo as $eachpho) {

                   $image = str_replace(' ', '+', $eachpho);

                   $imageName = 'report_task-'.Str::random(10).'.png';
                   $folderPath = "report_task_file/photos/";
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

                    $videoName = 'report_task-'.Str::random(10).'.mp4';
                    $folderPath = "report_task_file/videos/";
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

                    $progresss = $request->progress."%";
                    $report_task = ReportTask::create([
                        'phase_task_id' => $request->phase_task_id,
                        'report_description' => $request->report_description,
                        'finished_date' => $request->finished_date,
                        'file_count' => $file_count ?? 0,
                        'checked_by' => $request->checked_by,
                        'task_status' => $request->task_status,
                        'total_stock_qty' => $total_qty ?? 0,
                        'progress' => $progresss,
                        'performance'=> $perfor, //
                        'performance_status' => $per_status,

                    ]);

                    if($request->photo !=null){
                    ReportTaskFile::create([
                        'report_task_id' => $report_task->id,
                        'file_type'=>1,
                        'file' =>json_encode($photo_arr),
                     ]);
                    }

                    if($request->video !=null)
                        {
                            ReportTaskFile::create([
                                'report_task_id' => $report_task->id,
                                'file_type' => 2,
                                'file' => json_encode($video_arr),
                            ]);
                        }

                    return new ReportTaskResource($report_task);
    }

}
