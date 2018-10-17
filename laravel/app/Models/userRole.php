<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class userRole extends Model
{
    //
    protected $table = 'user_role';

    public function getMenu($uid)
    {
        return DB::select("SELECT * FROM menu where menu_id in (SELECT resourse_id FROM role_resourse where role_id in(SELECT role_id from user_role where admin_id=$uid) and type=0)");
    }

    public function comments()
    {
        return $this->hasMany('App\Models\RoleResourse','role_id');
    }
}
