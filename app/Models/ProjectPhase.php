<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class ProjectPhase extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function phasetasks()
    {
        return $this->hasMany(PhaseTask::class);

    }

    public function reports():HasManyThrough
    {
        return $this->hasManyThrough(ReportTask::class,PhaseTask::class);
    }
}
