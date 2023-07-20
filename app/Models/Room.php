<?php

namespace App\Models;

use App\Models\Building;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    use HasFactory;


    protected $fillable = [
        'room_number', 'building_id', 'room_type_id'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function assetrequest(): HasMany
    {
        return $this->hasMany(Asset::class)->select(['id', 'name', 'code', 'room_id']);
    }

    public function asset(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
