<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssue extends Model
{
    use HasFactory;

    protected $fillable = [
    	'material_issue_no','purchase_order_id','total_qty','material_request_id','project_id','project_phase_id','item_list','approve','delivery_order_status','status','warehouse_transfer_status','delivery_order_status'
    ];
}
