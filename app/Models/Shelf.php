<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    use HasFactory;
    protected $with=['zone'];

    protected $fillable = [
        'shelf_name',
        'zone_id',
        'shelf_description'
    ];

    public function zone(){
     return $this->belongsTo(Zone::class,'zone_id');
    }
}
