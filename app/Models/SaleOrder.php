<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SaleOrder extends Model
{
    use HasFactory;

    protected $fillable = [
     'sale_order_no','project_id','phase_id','delivery_date'
    ];

    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function phase():BelongsTo
    {
        return $this->belongsTo(ProjectPhase::class,'phase_id');
    }

    public function orderList():HasMany
    {
        return $this->hasMany(SaleOrderList::class);
    }
}
