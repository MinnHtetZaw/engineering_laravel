<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'=>$this->id,
            'sale_order_no'=>$this->sale_order_no,
            'delivery_date'=>$this->delivery_date,
            'project'=>$this->project->name,
            'phase'=>$this->phase->phase_name,
            'products'=>SaleOrderListResource::collection($this->orderList)
        ];
    }
}
