<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MaterialIssueResource extends JsonResource
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
            'material_issue_no'=>$this->material_issue_no,
            'total_qty'=>$this->total_qty,
            'request_material_id'=>$this->request_material_id,
            'purchase_order_id'=>$this->purchase_order_id,
            'customer_name'=>$this->customerInfo()['name'],
            'phone'=>$this->customerInfo()['phone'],
            'project_id'=>$this->project_id,
            'project_name'=>$this->project->name,
            'project_phase_id'=>$this->project_phase_id,
            'phase_name'=>$this->phase->phase_name,
            'transfer_date'=>$this->warehouseTransfer->date ?? "",
            'isApproved'=>$this->isApproved,
            'delivery_order_status'=>$this->delivery_order_status,
            'warehouse_transfer_status'=>$this->warehouse_transfer_status,
            'status'=>$this->status,
            'items'=>MaterialIssueListResource::collection($this->issueList)
        ];
    }
}
