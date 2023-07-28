<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['request_date','employee_id','reason','requested_by','project_id','project_phase_id','isApproved'];

    public function employee():BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function products():HasMany
    {
        return $this->hasMany(RequestMaterialList::class);
    }
    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    public function phase():BelongsTo
    {
        return $this->belongsTo(ProjectPhase::class,'project_phase_id');
    }

    public function getIsApprovedAttribute($value)
    {
        switch ($value) {
            case 0:
                return 'Pending';
                break;
            case 1:
                return 'Approved';
                break;
            case 2;
                return 'Declined';
                break;
        }
    }
}

