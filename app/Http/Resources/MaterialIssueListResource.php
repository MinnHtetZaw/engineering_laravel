<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialIssueListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return   [
            'id'=>$this->id,
            'item_id'=>$this->item_id,
            'item_model'=>$this->item->model,
            'item_serial_no'=>$this->item->serial_no,
            'item_brand'=>$this->item->product->brand->brand_name,
            'issue_qty'=>$this->issue_qty
        ];
    }
}
