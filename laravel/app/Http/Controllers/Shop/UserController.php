<?php

namespace App\Http\Controllers\Shop;

use App\Services\UserService;
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /*
     * 渲染登录模板
     * */
    public function login()
    {
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
            $data=Input::get();
            unset($data['_token']);
            $rules=['captcha'=>'required|captcha'];
            $volidata=Validator::make($data,$rules);
            if($volidata->fails()){
                //提示错误跳会注册页面
                return view('remind.remind',['msg'=>'验证码输入错误']);
            }
            //判断密码是否一致
            if($data['password'] !== $data['repassword']){
                return view('remind.remind',['msg'=>'两次输入的密码不一致']);
            }

            unset($data['repassword']);
            unset($data['captcha']);
            $data['password'] = md5($data['password']);
            //判断是否是邮箱注册
            if(isset($data['email'])){

            }else{
                $service=new UserService();
                if($service->register($data)){
                    return view('remind.remind',['url'=>'login','msg'=>'注册成功']);
                }
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
        $rules=['captcha'=>'required|captcha'];
        $validata=Validator::make($data,$rules);
//        判断验证码是否输入正确
        if($validata->fails()){
            return 'error';
        }else{
            unset($data['_token']);
            unset($data['captcha']);
            $data['pwd']=md5($data['pwd']);
            $state=DB::table('user')->where($data)->first();
            if(empty($state)){
                return 'wrong';
            }else{
                session(['uid'=>$state['uid']]);
                return 'success';
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
}
