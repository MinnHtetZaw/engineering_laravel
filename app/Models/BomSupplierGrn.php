<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomSupplierGrn extends Model
{
    use HasFactory;
    protected $fillable = [
        'grn_no',
        'grnDate',
        'bom_sup_po_id',
        'arrived_qty',
        'po_total_qty',
       'recevied_by',
        'delivered_by',
    ];

    public function item(){
    	return $this->belongsToMany(Item::class);
    }
}
