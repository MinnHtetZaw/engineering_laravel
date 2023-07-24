<?php

namespace App\Http\Resources;

use App\Models\ReportRequestMinatenanceFile;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportRequestMaintenanceResource extends JsonResource
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
            'request_maintenance_id'=>$this->request_maintenance_id,
            'request_no'=>$this->request->request_no,
            'total_stock_qty'=>$this->total_stock_qty,
            'finished_date'=>$this->finished_date,
            'progress'=>$this->progress,
            'performance'=>$this->performance,
            'performance_status'=>$this->performance_status,
            'report_description'=>$this->report_description,
            'file_count'=>$this->file_count,
            'checked_by'=>$this->checked_by,
            'files'=> ReportRequestMaintenanceFileResource::collection($this->files)
        ];
    }
}
