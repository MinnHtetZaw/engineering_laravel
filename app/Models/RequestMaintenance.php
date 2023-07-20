<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_no',
        'requset_date',
        'condition',
        'requirement_remark',
        'asset_id',
        'due_date',
        'employee_id',
        'finish_status',
    ];

    public function asset():BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function reports():HasMany
    {
        return $this->hasMany(ReportRequestMaintenance::class);
    }
}
