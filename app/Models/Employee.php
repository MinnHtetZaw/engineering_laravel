<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $hidden =['created_at','updated_at'];
    protected $fillable =['name','email','user_id','role_id'];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function role():BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

}
