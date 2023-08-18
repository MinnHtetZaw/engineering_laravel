<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrderList extends Model
{
    use HasFactory;
    protected $fillable = [
    	'delivery_order_id','item_id','product_id','issue_qty','reject_qty','reject_status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
