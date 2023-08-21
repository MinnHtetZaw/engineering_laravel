<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrderResource extends JsonResource
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
        'do_no'=>$this->do_no,
        'request_material_id'=>$this->request_material_id,
        'material_issue_id'=>$this->material_issue_id,
        'purchase_order_id'=>$this->purchase_order_id,
        'warehouse_transfer_id'=>$this->warehouse_transfer_id,
        'project_id'=>$this->project_id,
        'project'=>$this->project->name,
        'project_phase_id'=>$this->project_phase_id,
        'project_phase'=>$this->phase->phase_name,
        'user_id'=>$this->user_id,
        'receive_person'=>$this->receive_person,
        'phone'=>$this->phone,
        'delivery_date'=>$this->delivery_date,
        'location'=>$this->location,
        'status'=>$this->status,
        'approve'=>$this->approve,
        'delivery_order_list'=>DeliveryOrderListResource::collection($this->deliveryOrderList)
        ];
    }
}
