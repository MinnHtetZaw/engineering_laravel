<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReportTask extends Model
{
    use HasFactory;
    protected $with = ['files'];

    protected $fillable = [

        'total_stock_qty',
        'phase_task_id',
        'finished_date',
        'report_description',
        'checked_by',
        'task_status',
        'progress',
        'performance',
        'performance_status',
        'file_count'
    ];
    public function task()
    {
        return $this->belongsTo(PhaseTask::class,'phase_task_id');
    }
    public function items()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function files():HasMany
    {
        return $this->hasMany(ReportTaskFile::class);
    }



}
