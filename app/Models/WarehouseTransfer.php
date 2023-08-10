<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_transfer_no',
        'regional_warehouse_id',
        'date',
        'total_qty',
        'deliver_status',
        'accept_status',
    ];

    public function regWare()
    {
        return $this->belongsTo(RegionalWarehouse::class,'regional_warehouse_id');
    }

    public function materialIssues()
    {
        return $this->hasMany(MaterialIssue::class);
    }
}
