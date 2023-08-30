<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormList extends Model
{
    use HasFactory;

    protected $fillable =[
        'form_name','prefix','check_by','approve_by','prepare_by','index_digit',
    ];

    public function checkByRole()
    {
        return $this->belongsTo(Role::class,'check_by');
    }

    public function approveByRole()
    {
        return $this->belongsTo(Role::class,'approve_by');
    }

    public function prepareByRole()
    {
        return $this->belongsTo(Role::class,'prepare_by');
    }
}
