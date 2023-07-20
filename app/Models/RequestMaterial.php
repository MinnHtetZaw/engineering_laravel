<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['request_date','employee_id','reason','requested_by'];

    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function products():HasMany
    {
        return $this->hasMany(RequestMaterialList::class);
    }
}
