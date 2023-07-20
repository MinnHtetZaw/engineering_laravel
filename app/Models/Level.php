<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $with=['zone','shelf'];

    protected $fillable =[
        'level_code',
        'level_name',
        'level_description',
        'zone_id',
        'shelf_id'
    ];

    public function zone(){
        return $this->belongsTo(Zone::class,'zone_id');
    }

    public function shelf(){
        return $this->belongsTo(Shelf::class,'shelf_id');
    }
}
