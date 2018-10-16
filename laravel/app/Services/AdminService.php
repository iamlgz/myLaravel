<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/16
 * Time: 11:52
 */

namespace App\Services;

use App\Models\Menu;
use App\Models\AdminUser;
use App\Models\RoleResourse;
use App\Models\userRole;

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
            session('admin_user',$user);
        }
        $this->menuControl($user['admin_id']);
    }

    public function menuControl($uid)
    {
        $roleModel = new userRole();
        $ids = '';
        $roleId = $roleModel->getRoleId($uid);
        foreach ($roleId as $v) {
            $ids.='role_id='.$v['role_id'].' or ';
        }
        $ids=rtrim($ids,'or ');
        $sourseModel = new RoleResourse();
        var_dump($sourseModel->getSourse($ids));
        die;
    }

    /*
     * 处理后台菜单
     * */
    public static function getMenu()
    {
        $model = new Menu();
        $data = $model->getMenu();
        $res = self::getTree($data);
//        dump($res);die;
        return $res;
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

}