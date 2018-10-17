<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/16
 * Time: 11:52
 */

namespace App\Services;

use App\Models\AdminUser;
use App\Models\Button;
use App\Models\Goods;
use App\Models\Menu;
use App\Models\userRole;
use Illuminate\Support\Facades\Redis;

class AdminService
{

    /*
     * 登录验证
     * */
    public function loginVerrify($data)
    {
        $model = new AdminUser();
        $userInfo['admin_username'] = $data['email'];
        $userInfo['admin_password'] = md5($data['password']);
        $user = $model->login($userInfo);
        if(empty($user)){
            return false;
        }else{
            if(isset($data['remember'])){
                $time = 24*3600;
            }else{
                $time = 3600;
            }
            session_set_cookie_params($time);
            session_start();
            session(['admin_user' => $user]);
            return true;
        }
    }

    public static function menuControl()
    {
        $uid = session('admin_user')['admin_id'];
        $ressult = unserialize(Redis::get($uid));
        if(!$ressult){
            $roleModel = new userRole();
            $array = [];
            if(session('admin_user')['is_super']){
                $model = new Menu();
                $array = $model->getMenu();
            }else{
                $res = $roleModel->getMenu($uid);
                foreach ($res as $key => $val) {
                    $array[$key]['menu_id'] = $val->menu_id;
                    $array[$key]['text'] = $val->text;
                    $array[$key]['url'] = $val->url;
                    $array[$key]['label'] = $val->label;
                    $array[$key]['label_color'] = $val->label_color;
                    $array[$key]['icon'] = $val->icon;
                    $array[$key]['pid'] = $val->pid;
                }
            }
            $ressult = self::getTree($array);
            Redis::set($uid,serialize($ressult));
        }
        return $ressult;
    }

    public static function getTree($array,$pid = 0)
    {
        $tree= [];
        if (is_array($array)){
            foreach ($array as $k => $v) {
                if($pid == $v['pid']){
                    $v['submenu'] = self::getTree($array,$v['menu_id']);
                    $tree[] = array_filter($v);
                }
            }
        }
        return $tree;
    }

    /*
     * 获取分类及商品
     * */
    public function getGoods()
    {
        $model = new Goods();
        return $model->getTypeAndGoods();
    }

    /*
     * 获取按钮
     * */
    public function getButton($menu_id)
    {
        $uid = session('admin_user')['admin_id'];
        $menuModel = new Button();
        $arr = [];
        if(session('admin_user')['is_super']){
            $button = $menuModel->getAll($menu_id);
        }else{
            $button = $menuModel->getButton($menu_id,$uid);
        }
        foreach ($button as $item) {
            $arr[$item->button_id] = 1;
        }
        return $arr;
    }

}