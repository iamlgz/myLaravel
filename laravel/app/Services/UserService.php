<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/29
 * Time: 11:05
 */

namespace App\Services;


use App\Models\User;

class UserService
{
    /*
     * 实例化模型
     * */
    public function obj()
    {
        $obj=new User();
       return $obj;
    }

    /*
     * 注册
     * */
    public function register($data)
    {
        return $this->obj()->insert($data);
    }
}