<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    //
    protected $table = 'admin_user';

    public function login($userInfo)
    {
        return $this->where($userInfo)->first()->toArray();
    }
}
