<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_issue_no',
        'sale_order_id',
        'total_qty',
        'request_material_id',
        'project_id',
        'project_phase_id',
        'approve',
        'delivery_order_status',
        'status',
        'warehouse_transfer_status',
    ];
}
