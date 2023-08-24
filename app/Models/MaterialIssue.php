<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_issue_no',
        'purchase_order_id',
        'total_qty',
        'request_material_id',
        'project_id',
        'project_phase_id',
        'isApproved',
        'delivery_order_status',
        'status',
        'warehouse_transfer_status',
        'warehouse_transfer_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class,'project_phase_id');
    }

    public function issueList()
    {
        return $this->hasMany(MaterialIssueList::class);
    }

    public function requestMaterials()
    {
        return $this->belongsTo(RequestMaterial::class,'request_material_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
    public function warehouseTransfer()
    {
        return $this->belongsTo(WarehouseTransfer::class);
    }

    public function customerInfo()
    {
        if($this->purchase_order_id != null && $this->request_material_id == null)
        {
            return [
                'name' => $this->purchaseOrder->customer_name,
                'phone'=> $this->purchaseOrder->phone
            ];
        }
        else{

            return[
                'name' =>$this->requestMaterials->requested_by,
                'phone'=> $this->requestMaterials->employee->user->phone
            ];
        }
    }

}
