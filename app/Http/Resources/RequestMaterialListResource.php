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
            'quantity'=>$this->quantity
        ];
    }
}
