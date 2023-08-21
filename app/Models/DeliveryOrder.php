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
    public function issue()
    {
        return $this->belongsTo(MaterialIssue::class);
    }
    public function requestMaterial()
    {
        return $this->belongsTo(RequestMaterial::class);
    }
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function customerName()
    {
        if($this->purchase_order_id == null && $this->request_material_id != null)
        {
            return $this->requestMaterial->requested_by;
        }
        else{
            return $this->purchaseOrder->customer_name;
        }
    }
}
