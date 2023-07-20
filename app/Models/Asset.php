<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asset extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'code',
        'type',
        'room_id',
        'purchase_date',
        'price',
        'salvage_price',
        'use_life',
        'yearly_depriciation',
        'warranty',
        'warranty_docs',
        'warranty_status',
        'last_maintenance_date',
        'next_maintenance_date'
    ];

    public function room():BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

}
