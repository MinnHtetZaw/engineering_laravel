<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_issue_no',
        'sale_order_id',
        'total_qty',
        'request_material_id',
        'project_id',
        'project_phase_id',
        'isApproved',
        'delivery_order_status',
        'status',
        'warehouse_transfer_status',
        'warehouse_transfer_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function phase()
    {
        return $this->belongsTo(ProjectPhase::class,'project_phase_id');
    }

    public function issueList()
    {
        return $this->hasMany(MaterialIssueList::class);
    }
}
