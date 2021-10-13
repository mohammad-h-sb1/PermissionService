<?php

namespace Saberyp\Cms\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded=[];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'permission_role',);
    }

}
