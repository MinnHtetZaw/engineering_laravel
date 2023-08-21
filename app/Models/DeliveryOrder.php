<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'do_no',
        'request_material_id',
    	'material_issue_id',
        'purchase_order_id',
        'warehouse_transfer_id',
        'project_id',
        'project_phase_id',
        'user_id',
        'receive_person',
        'phone',
        'delivery_date',
        'location',
        'status',
        'approve',
    ];

    public function deliveryOrderList()
    {
        return $this->hasMany(DeliveryOrderList::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class,'project_phase_id');
    }
}
