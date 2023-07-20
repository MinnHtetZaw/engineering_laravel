<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Building extends Model
{
    use HasFactory;

    protected $fillable= ['name','number_per_floor'];

    public function floor():HasOne
    {
        return $this->hasOne(Floor::class);
    }
    public function room():HasMany
    {
		return $this->hasMany(Room::class);
	}
}
