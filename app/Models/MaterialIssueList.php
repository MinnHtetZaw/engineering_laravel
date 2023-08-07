<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssueList extends Model
{
    use HasFactory;

    protected $fillable = [
    	'material_issue_id','product_id','issue_qty',
    ];
}
