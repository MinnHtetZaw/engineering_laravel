<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteItemResource extends JsonResource
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
            "id"=>$this->id,
            "zone"=>$this->level->zone->name,
            "shelf"=>$this->level->shelf->shelf_name,
            "level"=>$this->level->level_name,
            "serial_no"=>$this->serial_no,
            "model"=>$this->model,
            "size"=>$this->size,
            "color"=>$this->color,
            "dimension"=>$this->dimension,
            "hs_code"=>$this->hs_code,
            "other_specification"=>$this->other_specification,
            "condition_type" =>$this->condition_type,
            "condition_remark" =>$this->condition_remark,
            "damage_remark"=>$this->damage_remark,
            "stock_qty"=>$this->stock_qty
        ];
    }
}
