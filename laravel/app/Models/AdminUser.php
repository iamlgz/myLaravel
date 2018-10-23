<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    //
    protected $table = 'admin_user';

    public function login($userInfo)
    {
        return $this->where($userInfo)->first();
    }

    /*
     * 管理员添加
     * */
    public function adminAdd($arr)
    {
        return $this->insertGetId($arr);
    }

    /*
     * 查找所有的管理员与角色
     * */
    public function getAdmin()
    {
        return $this->leftJoin('user_role','admin_user.admin_id','=','user_role.admin_id')->leftJoin('role','user_role.role_id','=','role.id')->paginate(10);
    }

    /*
     * 获取某个管理员的信息
     * */
    public function getOne($admin_id)
    {
        return $this->join('user_role','admin_user.admin_id','=','user_role.admin_id')->where(['admin_user.admin_id'=>$admin_id])->first();
    }

    /*
     * 修改管理员信息
     * */
    public function updateAdmin($data,$admin_id)
    {
        return self::where(['admin_id'=>$admin_id])->update($data);
    }

    /*
     * 删除管理员
     * */
    public function adminDel($admin_id)
    {
        return $this->where(['admin_id'=>$admin_id])->delete();
    }
}
