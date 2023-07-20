<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $with=['asset'];

    protected $fillable = [

        'last_maintenance_date',
        'next_maintenance_date',
        'type',
        'remark',
        'person',
        'maintenance_docs',
        'asset_id'
    ];

    public function asset(){
        return $this->belongsTo(Asset::class,'asset_id');
    }
}
