<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaterialIssueListResource;
use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderList;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueList;
use App\Models\RequestMaterial;
use App\Models\WarehouseTransfer;
use Illuminate\Http\Request;

class RegionalWarehouseController extends Controller
{
    //

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
            $DO_code = "DO-".sprintf("%04s", ($DO->id));
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

}
