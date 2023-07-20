<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportRequestMaintenance extends Model
{
    use HasFactory;
    protected $with = ['files'];

    protected $fillable = [

        'total_stock_qty',
        'request_maintenance_id',
        'finished_date',
        'report_description',
        'checked_by',
        'progress',
        'performance',
        'performance_status',
        'file_count'
    ];
    public function request()
    {
        return $this->belongsTo(RequestMaintenance::class,'request_maintenance_id');
    }
    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function files():HasMany
    {
        return $this->hasMany(ReportRequestMinatenanceFile::class,'report_req_maintain_id');
    }
}
