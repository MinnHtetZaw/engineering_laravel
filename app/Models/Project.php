<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable =['name','description','estimate_date','submission_date','rfq_file_path',
    'status', 'year','project_value','expected_budget','location','project_contact_person', 'phone','email',
    'customer_id','roi_value','team'
];

    public function phases():HasMany
    {
        return $this->hasMany(ProjectPhase::class);
    }
}
