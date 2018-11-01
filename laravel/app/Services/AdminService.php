<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/16
 * Time: 11:52
 */

namespace App\Services;

use App\Models\AdminUser;
use App\Models\Attributes;
use App\Models\AttrVal;
use App\Models\Button;
use App\Models\Category;
use App\Models\Goods;
use App\Models\GoodsAttributes;
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
        if($ressult){
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

    /*
     *属性列表
     * */
    public function attrList()
    {
        $model = new Attributes();
        return $model->getAll();
    }

    /*
     * 属性添加
     * */
    public function attrAdd($data)
    {
        $model = new Attributes();
        return $model->attrAdd($data);
    }

    /*
     * 查找某一条属性
     * */
    public function attrFind($id)
    {
        $model = new Attributes();
        return $model->attrFind($id);
    }

    /*
     * 属性修改
     * */
    public function attrUpdate($data)
    {
        $id = $data['id'];
        $arr = ['name' => $data['attr_name']];
        $model = new Attributes();
        return $model->attrUpdate($id,$arr);
    }

    /*
     * 属性值查询
     * */
    public function getAttrVal()
    {
        $model = new AttrVal();
        return $model->getAll();
    }

    /*
     * 查询出所有的属性
     * */
    public function getAllAtrributes()
    {
        $model = new Attributes();
        return $model->getAllAtrributes();
    }

    /*
     * 属性值添加
     * */
    public function attrValAdd($data)
    {
        $arr = ['attr_id'=>$data['attr_id'],'val_name'=>$data['name']];
        $model = new AttrVal();
        return $model->attrValAdd($arr);
    }

    /*
     * 分类查询
     * */
    public function getCategory()
    {
        $model = new Category();
        return $model->getCategory();
    }

    /*
     * 分类添加
     * */
    public function categoryAdd($data,$file)
    {
        $arr = [];
        $arr['c_name'] = $data['category_name'];
        $arr['url'] = $data['url'];
        $arr['pid'] = $data['pid'];
        $arr['attr_ids'] = implode(',',$data['attrid']);
        $arr['img'] = substr($file->store('public/img'),strpos($file->store('public/img'),'/')) ?? '';
        $model = new Category();
        return $model->addCategory($arr);
    }

    /*
     * 分类lieb
     * */
    public function categoryList()
    {
        $model = new Category();
        return $model->categoryList();
    }

    /*
     * 分类查询某一条
     * */
    public function getCateOne($id)
    {
        $model = new Category();
        return $model->getOne($id);
    }

    /*
     * 分类修改
     * */
    public function cateUpdate($data,$file)
    {
        $arr = [];
        $id = $data['id'];
        $model = new Category();
        if(empty($file)){
            $res = explode('/',$data['pid']);
            $pid = $res[0];
            if($pid!=0){
                $arr['path'] = $res[1];
            }
            $arr['pid'] = $pid;
            $arr['c_name'] = $data['category_name'];
            $arr['url'] = $data['url'];
        }
        return $model->cateUpdate($id,$arr);
    }

    public function getCate()
    {
        $model = new Category();
        return $model->getCate();
    }

    public function getAttr()
    {
        $model = new Attributes();
        return $model->getAllAtrributes();
    }

    public function getCateVal($ids)
    {
        $model = new AttrVal();
        $AttrModel = new Attributes();
        $result = $AttrModel->getIn($ids)->toarray();
        $data = $model->getAttrVal($ids)->toarray();
        $str = '';
        foreach ($result as $k => $v) {
            $str .= '<tr><td  style="width: 200px;text-align: center;" class="lgz" id="'.$v['id'].'">'.$v['name'].'</td><td class="iamlgz">';
            foreach ($data as $key => $val) {
                if($v['id']==$val['attr_id']){
                    $str.='<input type="checkbox" value="'.$val['id'].'" name="'.$v['id'].'[]" id="sku">'.$val['val_name'].'&nbsp;&nbsp;';
                }
            }
            $str.='</td></tr>';
        }
        return $str;
    }

    public function getAttrIn($ids)
    {
        $model = new Attributes();
        return $model->getIn($ids);
    }

    public function goodsAdd($data,$file)
    {
        $str = '';
        foreach ($file as $v) {
            $str .= substr($v->store('public/img'),strpos($v->store('public/img'),'/')).',';
        }

        $arr['goods_img'] = rtrim($str,',');
        $arr['goods_name'] = $data['goods_name'];
        $arr['goods_price'] = $data['goods_price'];
        $arr['promotion_price'] = $data['promotion_price'];
        $arr['is_sale'] = $data['is_sale'];
        $arr['cid'] = $data['t_id'];
        $arr['description'] = $data['content'];
        $arr['create_at'] = time();
        $model = new Goods();
        $array = [];
        $goods_id = $model->addGoods($arr);
        foreach ($data['attributes'] as $k => $v) {
            $array['attr_val_id'] = implode(',',$data["$v"]).',';
        }
        $array['attr_id'] = implode(',',$data['attributes']);
        $array['attr_val_id'] = rtrim($array['attr_val_id'],',');
        $array['goods_id'] = $goods_id;
        $attrvalModel = new GoodsAttributes();

        return $attrvalModel->addGoodsAttr($array);
    }

    public function getAttrValIn($ids)
    {
        $model = new AttrVal();
        return $model->getAttrValIn($ids)->toarray();
    }
}