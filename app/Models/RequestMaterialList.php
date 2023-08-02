<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestMaterialList extends Model
{
    use HasFactory;

    protected $fillable = ['request_material_id','product_id','requested_quantity','approved_quantity'];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function instockQty()
    {
        $items = $this->product->items;
        $qty =collect($items)
            ->groupBy('product_id')
            ->map(function ($query){
                 return ["required" =>$query->where('warehouse_type',1)->sum('stock_qty')];
             })
             ->value('required');

        return $qty;
    }

    public function requiredQty()
    {
        $instock = $this->instockQty();
        $req_qty = $this->requested_quantity;


            if($req_qty > $instock) return $req_qty - $instock;
            else return 0;
    }

}
