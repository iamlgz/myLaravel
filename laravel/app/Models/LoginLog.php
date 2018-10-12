<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table='login_log';

    /*
     * 查询登录用户总条数
     * */
    public function count($uid)
    {
        return $this->where(['uid'=>$uid])->count();
    }

    /*
     * 超过10次记录删除最早一次
     * */
    public function moveMin($uid)
    {
        $min=$this->where(['uid'=>$uid])->orderBy('id','asc')->first();
        return $min->delete();
    }

    /*
     * 插入一条记录
     * */
    public function add($arr)
    {
        return $this->insert($arr);
    }
}
