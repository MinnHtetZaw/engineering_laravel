<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warehouse_type',
        'warehouse_id',
        'site',
        'serial_no',
        'model',
        'size',
        'color',
        'dimension',
        'hs_code',
        'other_specification',
        'reserved_flag',
        'in_transit_flag',
        'in_stock_flag',
        'delivered_flag',
        'active_flag',
        'site_direct_flag',
        'condition_type',
        'condition_remark',
        'damage_remark',
        'unit_purchase_price',
        'unit_selling_price',
        'currency_type_id',
        'supplier_id',
        'purchase_date',
        'delivered_date',
        'registered_date',
        'item_location',
        'stock_qty',
        'level_id',
        'grn_flag'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
