<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/29
 * Time: 11:05
 */

namespace App\Services;

use App\Jobs\SendReminderEmail;
use App\Models\LoginLog;
use App\Models\User;
use Illuminate\Foundation\Bus\DispatchesJobs;


class UserService
{
    use DispatchesJobs;


    /*
     * 邮箱注册
     * */
    public function register($data)
    {
        $model = new User();
        $data['password'] = md5($data['password']);
        $data['username'] = '小米'.microtime(time());
        $res=$model->register($data);
        session(['user' => serialize($res)]);
        session(['username' => $res->username]);
        if(!empty($res->email)){
        $this->dispatch(new SendReminderEmail($res));
        }
        return $res;
    }

    /*
     * 登录
     * */
    public function login($data)
    {
        $model = new User();
        $data['password'] = md5($data['password']);
        $res=$model->login($data);
        if(empty($res)){
            return false;
        }else{
            //记录近十次登录地点时间IP
            $user = $res->toArray();
            $info = $this->getCityAndIp();

            $arr = [
                'uid' => $user['id'],
                'login_at' => time(),
                'login_ip' => $info['ip'],
                'login_address' => $info['city'],
                'login_mode' => $this->loginMode()
            ];
            $log=new LoginLog();
            if($log->count($user['id']) == 10){
                $log->moveMin($user['id']);
            }
            $log->add($arr);
            session(['user'=>serialize($res)]);
            session(['username'=>$user['username']]);
            return true;
        }
    }

    /*
     * 判断登录方式
     * */
    public function loginMode()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        $is_pc = (strpos($agent, 'windows nt')) ? true : false;
        $is_mac = (strpos($agent, 'mac os')) ? true : false;
        $is_iphone = (strpos($agent, 'iphone')) ? true : false;
        $is_android = (strpos($agent, 'android')) ? true : false;
        $is_ipad = (strpos($agent, 'ipad')) ? true : false;
        if($is_mac){
            return  "mac pc";
        }

        if($is_iphone){
            return  "iphone";
        }

        if($is_android){
            return  "android";
        }

        if($is_ipad){
            return  "ipad";
        }
        if($is_pc){
            return  "windows pc";
        }
    }

    /*
     * 获取登录IP
     * */
    public function getCityAndIp()
    {
        $json = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=myip");
        $data = json_decode($json)->data;
        $arr['city'] = $data->city;
        $arr['ip'] = $data->ip;
        return $arr;
    }


    public function getUserById($id)
    {
        $model = new User();
        return $model->getInfoById($id)['username'];
    }



}