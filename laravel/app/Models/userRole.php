<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userRole extends Model
{
    //
    protected $table = 'user_role';

    public function getRoleId($uid)
    {
        return $this->where(['admin_id'=>$uid])->get(['role_id'])->toArray();
    }
}
