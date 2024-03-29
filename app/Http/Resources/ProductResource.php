<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'product_name'=>$this->product_name,
            'brand'=>$this->brand->brand_name,
            'category'=>$this->category->category_name,
            'subcategory'=>$this->subcategory->subcategory_name,
            'product_img'=>url('/images')."/".$this->product_img,
            'items'=> SiteItemResource::collection($this->items),
        ];
    }
}
