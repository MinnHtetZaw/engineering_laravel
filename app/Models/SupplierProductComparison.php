<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProductComparison extends Model
{
    use HasFactory;

    protected $with =['supplier','incoterm'];

    protected $fillable = [
        'supplier_id',
        'product_id',
        'primary_flag',
        'unit_purchase_price',
        'currency_id',
        'discount_type',
        'discount_value',
        'discount_condition',
        'discount_condition_value',
        'incoterm_id',
        'last_purchase_date',
        'total_purchase_qty',
        'delivery_leadtime',
        'leadtime_type',
        'credit_term_type',
        'credit_term_value',
        'credit_condition',
        'credit_condition_value',
        'credit_amount',
        'moq_price',
        'moq_qty',
    ];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id');
    }
    public function incoterm(){
        return $this->belongsTo(Incoterm::class,'incoterm_id');
    }
    
}
