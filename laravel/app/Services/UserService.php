<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/29
 * Time: 11:05
 */

namespace App\Services;

use App\Models\LoginLog;
use App\Models\User;

class UserService
{
    /*
     * 手机号注册
     * */
    public function registByTel($data)
    {
        $model = new User();
        return $model->registerByTel($data);
    }

    /*
     * 邮箱注册
     * */
    public function registByEmail($data)
    {
        $model = new User();
        return $model->registerByEmail($data);
    }

    /*
     * 登录
     * */
    public function login($data)
    {
        $model = new User();
        $res=$model->login($data);
        if(empty($res)){
            return null;
        }else{
            //记录近十次登录地点时间IP
            $user=$res->toArray();
            $ip=$this->getIP();
            $city=$this->getCity($ip);
            $arr=[
                'uid' => $user['id'],
                'login_at' => time(),
                'login_ip' => $ip,
                'login_address' => $city,
                'login_mode' => $this->isMobile()
            ];
            $log=new LoginLog();
            if($log->count($user['id']) == 10){
                $log->moveMin($user['id']);
            }
            if($log->add($arr)) return $res;

        }
    }

    /*
     * 判断登录方式
     * */
    public function isMobile()
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
    public function getIP()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                    /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                foreach ($arr AS $ip) {
                    $ip = trim($ip);
                    if ($ip != 'unknown') {
                        $realip = $ip;
                        break;
                    }
                }
                if(!isset($realip)){
                    $realip = "0.0.0.0";
                }
            } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $realip = $_SERVER['HTTP_CLIENT_IP'];
            } else {
                if (isset($_SERVER['REMOTE_ADDR'])) {
                    $realip = $_SERVER['REMOTE_ADDR'];
                } else {
                    $realip = '0.0.0.0';
                }
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
        $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';
        return $realip;
    }

    /*
     * 获取登录城市
     * */
    public function getCity($getIp)
    {
        // 获取当前位置所在城市
        $content = file_get_contents("https://api.map.baidu.com/location/ip?ip={$getIp}&ak=YIqKqk1gtxe1e7xNhaSTS71rOFwx1ARH&coor=bd09ll");
        $json = json_decode($content);
//        var_dump($json->status);
        if($json->status==0){
            $address = $json->{'content'}->{'address'};//按层级关系提取address数据
            $data['address'] = $address;
            return mb_substr($data['address'],0,3,'utf-8');
        }else{
            return "未知";
        }

    }

}