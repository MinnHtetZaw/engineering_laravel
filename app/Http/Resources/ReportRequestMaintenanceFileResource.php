<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportRequestMaintenanceFileResource extends JsonResource
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
            'report_request_maintenance_id'=>$this->report_req_maintain_id,
            'file_type'=>$this->file_type,
            'file'=>json_decode($this->file),
        ];
    }
}
