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
use App\Models\Role;
use App\Models\RoleResourse;
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
        $userInfo['admin_email'] = $data['email'];
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
            session(['admin_user' => $user->toArray()]);
            return true;
        }
    }

    /*
     *
     * */

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
        if(!empty($button)){
            foreach ($button as $item) {
                $arr[$item->button_id] = 1;
            }
        }

        return $arr;
    }

    /*
     * 获取所有角色
     * */
    public function getRole()
    {
        $model = new Role();
//        dump($model->getAll());die;
        return $model->getAll();
    }

    /*
     * 添加管理员
     * */
    public function adminAdd($data)
    {
        $role = [];
        $arr = [];
        $arr['admin_email'] = $data['admin_email'];
        $arr['admin_password'] = md5($data['password']);
        $arr['nickname'] = $data['nickname'];
        $arr['admin_mobile'] = $data['mobile'];
        $arr['is_freeze'] = $data['is_freeze'];
        $arr['create_name'] = $data['create_name'];
        $model = new AdminUser();
        $id = $model->adminAdd($arr);
        $role['role_id'] = $data['role_id'];
        $role['admin_id'] = $id;
        $roleModel = new userRole();
        $res = $roleModel->addAdmin($role);
        if($res && $id){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 获取管理员及角色
     * */
    public function getAdminAndRole()
    {
        $model = new AdminUser();
        return $model->getAdmin();
    }

    /*
     *  获取某个管理员的信息
     * */
    public function getAdmin($admin_id)
    {
        $model = new AdminUser();
        return $model->getOne($admin_id)->toarray();
    }

    /*
     * 修改管理员信息
     * */
    public function updateAdminInfo($data)
    {
        $role = [];
        $admin = [];
        $admin_id = $data['admin_id'];
        $role['role_id'] = $data['role_id'];
        $admin['admin_email'] = $data['admin_email'];
        $admin['nickname'] = $data['nickname'];
        $admin['admin_mobile'] = $data['mobile'];
        $admin['is_freeze'] = $data['is_freeze'];
        if(!empty($data['admin_password'])){
            $admin['admin_password'] = md5($data['admin_password']);
        }
        $adminModel = new AdminUser();
        $roleModel = new userRole();
        if($adminModel->updateAdmin($admin,$admin_id) && $roleModel->updateRole($admin_id,$role)){
            return true;
        }
    }

    /*
     * 删除某个管理员
     * */
    public function adminDel($admin_id)
    {
        $adminModel = new AdminUser();
        $userRole = new UserRole();
        if($adminModel->adminDel($admin_id) && $userRole->delAdmin($admin_id)){
            return true;
        }else{
            return false;
        }
    }

    /*
     * 获取某个角色信息
     * */
    public function getARole($role_id)
    {
        $model = new Role();
        return $model->getOne($role_id);
    }

    /*
     * 修改角色名称
     * */
    public function updateRole($data)
    {
        $role_name['role_name'] = $data['role_name'];
        $id = $data['role_id'];
        $model = new Role();
        return $model->updateRoleName($id,$role_name);
    }

    /*
     * 角色添加
     * */
    public function roleAdd($data)
    {
        $model = new Role();
        return $model->roleAdd(['role_name'=>$data['role_name']]);
    }

    /*
     *查找角色权限
     * */
    public function userRole()
    {
        $model = new Menu();
        return self::getTree($model->getMenu());
    }

    public function addPower($data)
    {
        $role_id = $data['role_name'];
        $roleResourse = new RoleResourse();
        $arr = [];
        foreach ($data['checkname'] as $key => $va) {
            $arr[]=['role_id'=>$role_id,'resourse_id'=>$va,'type'=>0];
        }
        return $roleResourse->changePower($role_id,$arr);
    }

    public function getMenuAndButton()
    {
        $MenuModel = new Menu();
        $menu = $MenuModel->getMenu();
        $buttonModel = new Button();
        $arr = [];
        foreach ($menu as $key => $va) {
            $va['son'] = $buttonModel->getAll($va['menu_id'])->toarray();
            $arr[]=$va;
        }
        return $arr;
    }

    /*
     *分配按钮权限
     * */
    public function addButtonPower($data)
    {
        $role_id = $data['role_name'];
        $arr = [];
        foreach ($data['checkname'] as $v) {
            $arr[] = ['role_id'=>$role_id,'resourse_id'=>$v,'type'=>1];
        }
        $model = new RoleResourse();
        return $model->changePower($role_id,$arr,1);
    }
}