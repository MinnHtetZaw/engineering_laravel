<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrderList extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','sale_order_id','qty'];

    public function saleOrder():BelongsTo
    {
        return $this->belongsTo(SaleOrder::class);
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
