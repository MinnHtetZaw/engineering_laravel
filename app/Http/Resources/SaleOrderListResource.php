<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleOrderListResource extends JsonResource
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
            'product_id'=>$this->product_id,
            'product_name'=>$this->product->product_name,
            'part_number'=>$this->product->part_number,
            'brand'=>$this->product->brand->brand_name,
            'instock_qty'=>$this->product->instock_quantity,
            'required_qty'=>$this->requiredQty(),
            'qty'=>$this->qty
        ];
    }
}
