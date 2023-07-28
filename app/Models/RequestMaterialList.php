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

}
