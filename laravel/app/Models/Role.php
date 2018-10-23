<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    //
    protected $table = 'role';

    public function getAll()
    {
        return DB::select("select * from role where role_name not in ('超级管理员')");
    }

    /*
     * 获取一个角色
     * */
    public function getOne($role_id)
    {
        return self::find($role_id);
    }

    /*
     * 修改一个角色名称
     * */
    public function updateRoleName($id,$role)
    {
        return self::where(['id'=>$id])->update($role);
    }

    /*
     * 角色添加
     * */
    public function roleAdd($data)
    {
        return self::insert($data);
    }
}
