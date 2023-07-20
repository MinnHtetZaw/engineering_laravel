<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhaseTask extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $fillable = ['task_name','description','start_date','end_date','project_phase_id','status','complete','progress'];

    public function project_phase(){
        return $this->belongsTo(ProjectPhase::class);
    }

    public function reports():HasMany
    {
        return $this->hasMany(ReportTask::class);
    }


    public function getProgressAttribute($value)
    {
        return $value."%";
    }

    
}
