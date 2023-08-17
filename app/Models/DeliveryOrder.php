<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $fillable = [
    	'material_issue_id',
        'ware_transfer_order_id',
        'deliver_status',
        'receive_person',
        'phone',
        'material_request_id',
        'purchase_order_id',
        'project_id',
        'phase_id',
        'item_list',
        'delivery_date',
        'approve',
        'status',
        'user_id',
        'location',
        'do_no',
        'reject_status'
    ];

}
