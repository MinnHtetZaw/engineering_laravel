<?php

namespace App\Http\Controllers;

use App\Http\Resources\MaterialIssueListResource;
use App\Models\MaterialIssue;
use App\Models\MaterialIssueList;
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

            $data =  WarehouseTransfer::with('regWare','materialIssues.project:id,name','materialIssues.phase:id,phase_name','materialIssues.requestMaterials')->get();

            return response()->json(['message'=>'Successfully Accepted Transfer',
                                    'data'=>$data]);
        }catch(\Exception $e)
        {
            return $e;
        }
    }
}
