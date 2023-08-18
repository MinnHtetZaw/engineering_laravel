<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomProductLists extends Model
{
    use HasFactory;

    protected $with = ['product.brand'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
