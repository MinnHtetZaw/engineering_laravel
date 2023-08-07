<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    // protected $with = ['category','brand','subcategory','primarysupplier','items','item_count'];
    // protected $with = ['item_count'];

    protected $fillable = [
        'department_id',
        'category_id',
        'subcategory_id',
        'brand_id',
        'product_name',
        'part_number',
        'measuring_unit',
        'register_date',
        'description',
        'instock_order',
        'min_order_quantity',
        'moq_price',
        'instock_quantity',
        'reorder_quantity',
        'primary_supplier_id',
        'second_supplier_id',
        'product_img',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function subcategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function primarysupplier(){
        return $this->belongsTo(Supplier::class,'primary_supplier_id');
    }

    public function items():HasMany
    {
        return $this->hasMany(Item::class);
    }
}
