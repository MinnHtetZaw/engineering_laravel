<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use App\Models\RequestMaterial;
use App\Models\RequestMaterialList;
use App\Http\Controllers\Controller;
use App\Http\Resources\RequestMaterialResource;

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
}
