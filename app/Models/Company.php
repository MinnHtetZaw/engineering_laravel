<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_contact',
        'company_email',
        'company_md_name',
        'financial_start_date',
        'financial_end_date',
        'starting_capital',
        'netprofit_pre_year',
        'netprofit_current_year',
    ];
    
}
