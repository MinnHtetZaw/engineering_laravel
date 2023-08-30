<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormListResource extends JsonResource
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
            'form_name'=>$this->form_name,
            'prefix'=>$this->prefix,
            'index_digit'=>$this->index_digit,
            'approve_by'=>$this->approve_by,
            'approve_by_role'=>$this->approveByRole->role,
            'check_by'=>$this->check_by,
            'check_by_role'=>$this->checkByRole->role,
            'prepare_by'=>$this->prepare_by,
            'prepare_by_role'=>$this->prepareByRole->role,
        ];
    }
}
