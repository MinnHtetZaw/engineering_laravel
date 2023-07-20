<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomSupplier extends Model
{
    use HasFactory;
    protected $with = ['supplier'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }   
}
