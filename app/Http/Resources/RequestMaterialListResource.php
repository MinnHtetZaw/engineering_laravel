<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestMaterialListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'request_material_list_id'=>$this->id,
            'product_id'=>$this->product_id,
            'name'=>$this->product->product_name,
            'requested_quantity'=>$this->requested_quantity,
            'approved_quantity'=>$this->approved_quantity,
            'instock_quantity'=>$this->instockQty(),
            'required_quantity'=>$this->requiredQty()
        ];
    }
}
