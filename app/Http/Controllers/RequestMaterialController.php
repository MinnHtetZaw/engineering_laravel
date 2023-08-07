<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestMaterialResource;
use App\Models\MaterialIssue;
use App\Models\RequestMaterial;
use App\Models\RequestMaterialList;
use Illuminate\Http\Request;

class RequestMaterialController extends Controller
{
    //
    public function storeRequestProduct(Request $request)
    {
        $data= RequestMaterial::create([
            'employee_id'=>$request->employee_id,
            'project_id'=>$request->project_id,
            'project_phase_id'=>$request->phase_id,
            'request_date'=>$request->request_date,
            'reason'=>$request->reason,
            'requested_by'=>$request->requested_by
        ]);

        foreach($request->products as $product)
        {
            RequestMaterialList::create([
                'request_material_id'=>$data->id,
                'product_id'=>$product['product_id'],
                'requested_quantity'=>$product['quantity'],
                'approved_quantity'=>$product['quantity'],
            ]);
        }

        return new RequestMaterialResource($data);
    }

    public function getRequestMaterialList()
    {
        return RequestMaterialResource::collection(RequestMaterial::all());
    }

    public function changeStatus(Request $request)
    {
        try {
            $data = RequestMaterial::findOrFail($request->request_id);
            $data->isApproved = $request->isApproved;
            $data->save();

        } catch (\Throwable $th) {
            return $th;
        }
        return response()->json($data);
    }

    public function showIssueList()
    {
        $data = MaterialIssue::all();

        return response()->json(['data'=>$data]);
    }

    public function saveMaterialIssue($id)
    {
        $data  =  RequestMaterial::find($id);
        $data->isIssued = 1;
        $data->save();

        $mi =  MaterialIssue::get()->last();
        if($mi)
        {
         $mi_num =  "MI-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", ($mi->id));
        }
        else{
         $mi_num =  "MI-" . sprintf("%02s", (intval(date('m')))) . sprintf("%03s", 1);
        }

        try{
                MaterialIssue::create([
                    'material_issue_no'=>$mi_num,
                    'purchase_order_id'
                ]);
        }
        catch(\Throwable $th)
        {
            return $th;
        }
    }
}
