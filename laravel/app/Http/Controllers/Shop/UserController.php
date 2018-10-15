<?php

namespace App\Http\Controllers\Shop;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /*
     * 渲染登录模板
     * */
    public function login()
    {
        if(session('uid')){
            return view('remind.remind',['msg'=>'您已登录','url'=>'index']);
        }
        return view('user.login');
    }

    /*
     * 用户订单渲染
     * */
    public function orderForGoods()
    {
        return view('user.order_for_goods');
    }

    /*
     * 注册渲染
     * */
    public function register(Request $request)
    {
        if($request->isMethod('post')){
            $data=$request->post();
            $rules=['captcha' => 'required|captcha'];
            $volidata=Validator::make($data,$rules);
            if($volidata->fails()){
                //提示错误跳会注册页面
                return view('remind.remind',['msg' => '验证码输入错误']);
            }
            //判断密码是否一致
            if($data['password'] !== $data['repassword']){
                return view('remind.remind',['msg' => '两次输入的密码不一致']);
            }
            $emailPreg = "/^\w+@\w+\.(com|cnc|net)$/";
            $mobilePreg = "/^1[3-9]{2}\d{8}$/";
            $arr = [];
            if(preg_match($emailPreg,$data['username'])){
                $arr['email'] = $data['username'];
            }elseif (preg_match($mobilePreg,$data['username'])){
                $arr['tel'] = $data['username'];
            }else{
                return view('remind.remind',['msg' => '请输入正确的用户名','url' => 'login']);
            }


            $arr['password'] = $data['password'];
            $service = new UserService();
            $result=$service->register($arr);
            if(!empty($result)){
                return view('remind.remind',['url' => 'index','msg' => '注册成功']);
            }else{
                return view('remind.remind',['msg' => '该邮箱已被注册']);
            }

        }
        return view('user.register');
    }

    /*
     * 用户个人信息
     * */
    public function selfInfo()
    {
        return view('user.self_info');
    }

    /*
     * 验证码验证
     * */
    public function verify()
    {
        $data=Input::get();
        //规则
        $rules=['captcha' => 'required|captcha'];
        $validata=Validator::make($data,$rules);
//        判断验证码是否输入正确
        if($validata->fails()){
            return view('remind.remind',['msg' => '验证码输入错误']);
        }else{
            $emailPreg = "/^\w+@\w+\.(com|cnc|net)$/";
            $mobilePreg = "/^1[3-9]{2}\d{8}$/";
            $arr=[];
            if(preg_match($emailPreg,$data['username'])){
                $arr['email'] = $data['username'];
            }elseif (preg_match($mobilePreg,$data['username'])){
                $arr['tel'] = $data['username'];
            }
            $arr['password'] = $data['password'];
            $service = new UserService();
            $res=$service->login($arr);
            if($res){
                return view('remind.remind',['msg'=>'登录成功','url'=>'index']);
            }else{
                return view('remind.remind',['msg'=>'账号或密码输入错误']);
            }
        }
    }

    /*
     * 手机号注册
     * */
    public function telRegist()
    {
        return view('user.tel_register');
    }

    /*
     * 通过手机登录
     * */
    public function loginByTel()
    {
        return view('user.tel_login');
    }

    /*
     * 退出登录
     * */
    public function loginOut()
    {
        session(['username'=>false,'user'=>false]);
        return view('remind.remind',['msg'=>'退出成功','url'=>'index']);
    }
}
