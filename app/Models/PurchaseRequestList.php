<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestList extends Model
{
    use HasFactory;

    protected $fillable = ['purchase_request_id','product_id','required_qty'];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    
}
