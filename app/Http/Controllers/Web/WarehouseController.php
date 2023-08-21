<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseTransferResource;
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
                    $matIssue = MaterialIssue::find($list['id']);
                    $matIssue->warehouse_transfer_status = 1;
                    $matIssue->warehouse_transfer_id = $transfer->id;
                    $matIssue->save();

                    $total +=$list['total_qty'];
            }
            $transfer->total_qty = $total;
            $transfer->save();
            return response()->json(['success'=>'Successfully Created!']);
        }
        catch(\Exception $e)
        {
            return response(500)->json($e);
        }
    }
}
