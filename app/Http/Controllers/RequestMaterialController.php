<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestMaterialResource;
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
            'request_date'=>$request->request_date,
            'reason'=>$request->reason,
            'requested_by'=>$request->requested_by
        ]);

        foreach($request->products as $product)
        {
            RequestMaterialList::create([
                'request_material_id'=>$data->id,
                'product_id'=>$product['product_id'],
                'quantity'=>$product['quantity'],
            ]);
        }

        return new RequestMaterialResource($data);
    }

    public function getRequestMaterialList()
    {
        return RequestMaterialResource::collection(RequestMaterial::all());
    }
}
