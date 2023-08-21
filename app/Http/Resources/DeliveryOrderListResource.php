<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrderListResource extends JsonResource
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
            'id'=>$this->id,
            'delivery_order_id'=>$this->delivery_order_id,
            'product_id'=>$this->product_id,
            'product_name'=>$this->product->product_name,
            'item_id'=>$this->item_id,
            'item_model'=>$this->item->model,
            'issue_qty'=>$this->issue_qty,
            'reject_qty'=>$this->reject_qty,
            'reject_status'=>$this->reject_status
        ];
    }
}
