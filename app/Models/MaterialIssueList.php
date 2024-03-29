<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialIssueList extends Model
{
    use HasFactory;

    protected $fillable = [
    	'material_issue_id','item_id','issue_qty',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
