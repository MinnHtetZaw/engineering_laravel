<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectPhase;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\MaterialIssue;
use App\Models\RequestMaterial;
use App\Models\DeliveryOrderList;
use App\Models\MaterialIssueList;
use App\Models\RegionalWarehouse;
use App\Models\WarehouseTransfer;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeliveryOrderResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\MaterialIssueListResource;

class RegWarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regionalwarehouses = RegionalWarehouse::with('project')->get();
        return response()->json([
            'regionalwarehouses' => $regionalwarehouses
        ],200);
    }


    public function store(Request $request)
    {
        $photoName = $request->warehouse_photo->getClientOriginalName();
        $photoPath = $request->file('warehouse_photo')->move(public_path('/warehouse_img'), $photoName);

        RegionalWarehouse::create([
            'warehouse_name' => $request->warehouse_name,
            'warehouse_photo' => $photoName,
            'region' => $request->region,
            'country' => $request->country,
            'location_address' => $request->location_address,
            'area' => $request->area,
            'capacity' => $request->capacity,
            'project_id' => $request->project_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => 'Regional Warehouse was saved!'
        ], 200);
    }

    public function regWarehouseProducts($id) {

        $items = Item::where('warehouse_id', $id)->get();

        $pdo = [];
        foreach($items as $item) {
            $product = Product::where('id', $item->product_id)->first();
            if (!in_array($product,$pdo)){
                array_push($pdo,$product);
            }

        }

        return response()->json([
            'products' => $pdo,
            'items' => $items,
        ],200);
    }

    public function projectFilter(Project $project)
    {
        return response()->json(['data'=>$project->phases]);
    }

    public function getIssueListByPhase(ProjectPhase $phase)
    {

            $data = MaterialIssue::where('project_phase_id',$phase->id)->where('warehouse_transfer_status',0)->get();
            $contact_person = $phase->supervisor->name;

            return response()->json([
                'data'=>$data,
                'contact_person'=>$contact_person
              ]);

    }

    public function searchProducts($id)
    {
        $data=MaterialIssueList::where('material_issue_id',$id)->get();

        return MaterialIssueListResource::collection($data);
    }

    public function acceptTransfer($id)
    {

        try{

            $WT=  WarehouseTransfer::find($id);
            $WT->accept_status = 1;
            $WT->save();

            $issues =   MaterialIssue::whereWarehouseTransferId($id)->get();

            foreach($issues as $issue)
            {
                $issue->status= 1;
                $issue->save();

                // Change MainWarehouse to Regional After Accept
                foreach($issue->issueList as $list)
                {
                        $item = Item::find($list->item_id);
                        $item->warehouse_type = 0;
                        $item->warehouse_id =$id;
                        $item->save();
                }
            }


            $data =  WarehouseTransfer::with('regWare','materialIssues.project:id,name','materialIssues.phase:id,phase_name','materialIssues.requestMaterials')->get();

            return response()->json(['message'=>'Successfully Accepted Transfer',
                                    'data'=>$data]);
        }catch(\Exception $e)
        {
            return $e;
        }
    }


    public function deliverTransfer($id)
    {
        try{

        $issue =   MaterialIssue::find($id);
        $issue->delivery_order_status = 1;
        $issue->save();

        $warehouse =  MaterialIssue::where('warehouse_transfer_id',$issue->warehouse_transfer_id)
                                    ->where('delivery_order_status',0)
                                    ->get();

        if($warehouse->isEmpty()){
            $WT = WarehouseTransfer::find($issue->warehouse_transfer_id);
            $WT->deliver_status = 1;
            $WT->save();
        }

        $DO =  DeliveryOrder::get()->last();

        if($DO)
        {
            $DO_code = "DO-".sprintf("%04s", ($DO->id+1));
        }
        else{
            $DO_code = "DO-".sprintf("%04s",1);
        }

        if($issue->purchase_order_id == null)
			{
				$reqMat = RequestMaterial::find($issue->request_material_id);

				$Deliver_order =new DeliveryOrder();
                    $Deliver_order->do_no = $DO_code;
					$Deliver_order->request_material_id = $reqMat->id;
					$Deliver_order->material_issue_id = $issue->id;
					$Deliver_order->warehouse_transfer_id = $issue->warehouse_transfer_id;
					$Deliver_order->project_id = $issue->project_id;
					$Deliver_order->project_phase_id = $issue->project_phase_id;
                $Deliver_order->save();

			}

			$material_issue_list = MaterialIssueList::where('material_issue_id',$issue->id)->get();

            foreach($material_issue_list as $matis_item)
			{
				    DeliveryOrderList::create([
					'delivery_order_id' => $Deliver_order->id,
                    'product_id'=>$matis_item->item->product_id,
					'item_id' => $matis_item->item_id,
					'issue_qty' => $matis_item->issue_qty,
				]);
			}

        $data =  WarehouseTransfer::with('regWare','materialIssues.project:id,name','materialIssues.phase:id,phase_name','materialIssues.requestMaterials')->get();

         return response()->json([
                                'message'=>'Successfully Accepted Transfer',
                                'data'=>$data
                                ]);
        }
        catch(\Exception $e)
        {
            return $e;
        }
    }

    public function site_delivery_order(){

    	$site_delivery_orders = DeliveryOrder::all();

    	return DeliveryOrderResource::collection($site_delivery_orders);

    }

    public function updateReceiveInfo(Request $request)
    {
        try{
            $delivery_order = DeliveryOrder::find($request->DOid);
            $delivery_order->receive_person = $request->receive_person;
            $delivery_order->phone = $request->phone;
            $delivery_order->location = $request->location;
            $delivery_order->delivery_date = $request->deliver_date;
            $delivery_order->save();

            return redirect()->route('Do#List');

        }catch(\Exception $e)
        {
            return $e;
        }

    }

    public function approveDO(Request $request)
    {
        $delivery_order = DeliveryOrder::find($request->id);
        $delivery_order->status = 1;
        $delivery_order->save();

        foreach($delivery_order->deliveryOrderList as $list)
        {
                $data = Item::find($list->item_id);
                $data->delivered_flag = 1;
                $data->in_transit_flag = 0 ;
                $data->save();
        }

        return redirect()->route('Do#List');
    }
}
