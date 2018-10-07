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
    public function login()
    {
        $obj=new User();
       return $obj->select();
    }
}