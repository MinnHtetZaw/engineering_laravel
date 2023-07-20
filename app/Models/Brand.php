<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_code', 'brand_name', 'category_id', 'subcategory_id', 'description', 'supplier_id', 'country_of_origin'
    ];

}
