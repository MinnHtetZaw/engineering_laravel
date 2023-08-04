<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = ['pr_no','request_date','project_id','project_phase_id','request_material_id','sale_order_id',];

    public function lists():HasMany
    {
        return $this->hasMany(PurchaseRequestList::class);
    }

    public function requestMaterial()
    {
        return $this->belongsTo(RequestMaterial::class);
    }
}
