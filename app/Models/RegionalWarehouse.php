<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class RegionalWarehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_name',
        'warehouse_photo',
        'region',
        'country',
        'location_address',
        'area',
        'capacity',
        'project_id',
        'email',
        'password'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
