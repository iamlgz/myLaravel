<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table='user';

    /*
     * 用户邮箱注册
     * */
    public function registerByEmail($data)
    {
        if(empty($this->where(['email'=>$data['email']])->first())){
            $data['username']='小米'.microtime(time());
            $id = $this->insertGetId($data);
            return $this->findOrFail($id);
        }else{
            return false;
        }
    }

    /*
     * 用户手机号注册
     * */
    public function registerByTel($data)
    {
        if(empty($this->where(['tel' => $data['tel']])->first())){
            $data['username']='小米'.microtime(true);
            return $this->insert($data);
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
