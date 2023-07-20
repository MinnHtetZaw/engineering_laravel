<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomSupplierProduct extends Model
{
    use HasFactory;

    protected $with =['productdetail'];

    public function productdetail(){
        return $this->belongsTo(Product::class,'product_id');
    }


}
