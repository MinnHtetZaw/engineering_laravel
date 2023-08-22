<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseTransferResource;
use App\Models\Item;
use App\Models\MaterialIssue;
use App\Models\WarehouseTransfer;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    //

    public function getList()
    {
        $data =  WarehouseTransfer::with('regWare','materialIssues.project:id,name','materialIssues.phase:id,phase_name','materialIssues.requestMaterials')->get();

        return response()->json(['data'=>$data]);
    }

    public function generateWTO()
    {
          $data =  WarehouseTransfer::get()->last();

            if($data)
            {
                $wto = sprintf("%04s", ($data->id +1));
            }
            else{
                $wto = sprintf("%04s",1);
            }

        return response()->json($wto);
    }

    public function createTransfer(Request $request)
    {
        try{
            $transfer =    WarehouseTransfer::create([
                'warehouse_transfer_no'=>$request->wto_no,
                'regional_warehouse_id'=>$request->regional_warehouse_id,
                'date'=>$request->date,
                'total_qty'=>0
             ]);

             $total = 0;
            foreach($request->issueList as $list)
            {
                    $total +=$list['total_qty'];

                    $matIssue = MaterialIssue::find($list['id']);
                    $matIssue->warehouse_transfer_status = 1;
                    $matIssue->warehouse_transfer_id = $transfer->id;
                    $matIssue->save();

                    foreach($matIssue->issueList as $mat_issue_list)
                    {
                           $item =Item::find($mat_issue_list->item_id);
                           $item->reserved_flag = 0 ;
                           $item->in_transit_flag = 1;
                           $item->save();
                    }


            }
            $transfer->total_qty = $total;
            $transfer->save();
            return response()->json(['success'=>'Successfully Created!']);
        }
        catch(\Exception $e)
        {
            return response()->json($e,500);
        }
    }
}
