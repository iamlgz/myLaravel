<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table='user';

    /*
     * 用户邮箱注册
     * */
    public function register($data)
    {
        if(!empty($data['email'])){
            $where = ['email'=>$data['email']];
        }elseif (!empty($data['tel'])){
            $where = ['tel'=>$data['tel']];
        }
        if(empty($this->where($where)->first())){
            $id = $this->insertGetId($data);
            return $this->findOrFail($id);
        }else{
            return false;
        }
    }

    /*
     * 登陆
     * */
    public function login($data)
    {
        if(is_array($data)){
            $res = $this->where($data)->first();
            if($res){
                $id = $res->toArray()['id'];
                $this->where(['id' => $id])->update(['last_login_at'=>time()]);
            }
            return $res;
        }
    }

    /*
     * 获取用户信息
     * */
    public function getInfoById($id)
    {
        return $this->where(['id'=>$id])->first(['username'])->toArray();
    }
}
