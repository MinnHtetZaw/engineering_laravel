<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_code',
        'account_name',
        'account_type',
        'project_id',
        'opening_balance',
        'general_project_flag',
        'cost_center_id',
        'currency_id',
        'carry_for_work',
        'amount'
    ];

    protected $with = ['currency','project'];

    public function project(){
    	return $this->belongsTo(Project::class);
    }

    public function currency(){
    	return $this->belongsTo(Currency::class);
    }

    public function getAccountTypeAttribute($account_type) {
        switch ($account_type) {
            case '1':
                return "Fixed-Asset";
                break;
            case '2':
                return "Current-Asset";
                break;
            case '3':
                return "Cash";
                break;
            case '4':
                return "Bank";
                break;
            case '5':
                return "Cash-In-Hand";
                break;
            case '6':
                return "Revenue";
                break;
            case '7':
                return "Receiveable";
                break;
            case '8':
                return "Expense";
                break;
            case '9':
                return "Payable";
                break;
            case '10':
                return "COGS";
                break;
            case '11':
                return "Accumulated Depriciation";
                break;
            case '12':
                return "Expense Depriciation";
                break;

            case '14':
                return "Other Revenue";
                break;
            case '15':
                return "Other Receiable";
                break;
            default:
                return "has";
                break;
        }
    }
}
