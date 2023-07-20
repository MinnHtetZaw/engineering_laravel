<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestMaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
        [
            'id'=>$this->id,
            'from_employee_id'=>$this->employee_id,
            'from_employee'=>$this->employee->name,
            'request_date'=>$this->request_date,
            'reason'=>$this->reason,
            'requested_by'=>$this->requested_by,
            'products'=>RequestMaterialListResource::collection($this->products)
        ];
    }
}
