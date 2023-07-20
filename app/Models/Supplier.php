<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'email', 
        'website', 
        'social', 
        'department', 
        'address',
        'country', 
        'sector', 
        'phone', 
        'fax', 
        'rank', 
        'remark'
    ];
}
