<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/15
 * Time: 14:30
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
{
    /*
     * 展示后台首页
     * */
    public function index()
    {
        return view('admin.index');
    }

    /*
     * 管理员登录
     * */
    public function login(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->post();
            $service = new AdminService();
            $res = $service->loginVerrify($data);
            if($res){
                return view('remind.remind',['msg' => '登陆成功','url' => 'index']);
            }else{
                return view('remind.remind',['msg' => '账号或密码输入错误']);
            }
        }
        return view('admin.login');
    }

    public function loginOut()
    {
        session()->forget('admin_user');
        return view('remind.remind',['msg'=>'退出成功','url'=>'login']);
    }

    public function adminAdd(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            $data = $request->post();
            if($data['password'] !== $data['repassword']){
                return view('remind.remind',['msg'=>'两次输入的密码不正确']);
            }

            if($service->adminAdd($data)){
                return view('remind.remind',['msg'=>'添加成功']);
            }
        }
        return view('admin.admin_add',['role'=>$service->getRole()]);
    }

    /*
     * 操管理商品
     * */
    public function operationGoods()
    {
        $menu_id = Input::get('menu_id');
        $service = new AdminService();
        return view('admin.goods_admin',['data' => $service->getGoods(),'button'=>$service->getButton($menu_id),'menu_id'=>$menu_id]);
    }

    /*
     * 管理管理员
     * */
    public function operationAdmin()
    {
        $menu_id = Input::get('menu_id');
        $service = new AdminService();
        return view('admin.operationAdmin',['data'=>$service->getAdminAndRole(),'menu_id'=>$menu_id,'button'=>$service->getButton($menu_id)]);
    }

    /*
     * 修改管理员信息
     * */
    public function adminUpdate(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            $data = $request->post();
            if($service->updateAdminInfo($data)){
                return view('remind.remind',['msg'=>'修改成功']);
            }
        }

        $admin_id = $request->get('admin_id');
        $data = $service->getAdmin($admin_id);
        $role = $service->getRole();
        return view('admin.admin_update',['data'=>$data,'role'=>$role]);
    }

    /*
     * 删除管理员
     * */
    public function adminDel(Request $request)
    {
        $admin_id = $request->get('admin_id');
        $service = new AdminService();
        if($service->adminDel($admin_id)){
            return view('remind.remind',['msg'=>'删除成功']);
        }else{
            return view('remind.remind',['msg'=>'删除失败']);
        }
    }

    /*
     * 角色列表
     * */
    public function roleList()
    {
        $menu_id = Input::get('menu_id');
        $service = new AdminService();
        return view('admin.role_list',['data'=>$service->getRole(),'button'=>$service->getButton($menu_id)]);
    }

    /*
     * 修改角色
     * */
    public function roleUpdate(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            $data = $request->post();
            if($service->updateRole($data)){
                return view('remind.remind',['msg'=>'修改成功']);
            }else{
                return view('remind.remind',['msg'=>'修改失败']);
            }
        }
        $role_id = $request->get('role_id');
        return view('admin.role_update',['data'=>$service->getARole($role_id)->toArray()]);
    }

    /*
     * 添加角色
     * */
    public function roleAdd(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            if($service->roleAdd($request->post())){
                return view('remind.remind',['msg'=>'添加成功']);
            }else{
                return view('remind.remind',['msg'=>'添加失败']);
            }
        }
        return view('admin.role_add');
    }

    /*
     * 删除角色
     * */
    public function roleDel()
    {
        $id = Input::get('role_id');
        dump($id);
    }

    /*
     * 角色添加权限
     * */
    public function roleAddPower(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            if($service->addPower($request->post())){
                return view('remind.remind',['msg'=>'修改成功']);
            }else{
                return view('remind.remind',['msg'=>'修改失败']);
            }
        }
        return view('admin.role_add_power',['role'=>$service->getRole(),'menu'=>$service->userRole()]);
    }

    public function roleAddButtonPower(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            if($service->addButtonPower($request->post())){
                return view('remind.remind',['msg'=>'修改成功']);
            }else{
                return view('remind.remind',['msg'=>'修改失败']);
            }
        }
        return view('admin.role_add_button_power',['role'=>$service->getRole(),'button'=>$service->getMenuAndButton()]);
    }

    /*
     * 商品添加
     * */
    public function goodsAdd(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            $file = $request->file('goods_img');
            $data = $request->post();
            if(empty($file)){
                return view('remind.remind',['msg'=>'请上传图片']);
            }
            if($service->goodsAdd($data,$file)){
                return view('remind.remind',['msg'=>'添加成功']);
            }else{
                return view('remind.remind',['msg'=>'添加失败']);
            }
        }

        return view('admin.goods_add',['cate'=>$service->getCate(),'attr'=>$service->getAttr()]);
    }

    /*
     * 商品属性列表
     * */
    public function attrList(Request $request)
    {
        $menu_id = $request->get('menu_id');
        $service = new AdminService();

        return view('admin.attr_list',['data' => $service->attrList(),'menu_id'=>$menu_id,'button'=>$service->getButton($menu_id)]);
    }

    /*
     * 商品属性添加
     * */
    public function attrAdd(Request $request)
    {
        if($request->isMethod('post')){
            $serive = new AdminService();
            if($serive->attrAdd(['name'=>$request->post('attr_name')])){
                return view('remind.remind',['msg'=>'添加成功!']);
            }else{
                return view('remind.remind',['msg'=>'添加失败!']);
            }
        }
        return view('admin.attr_add');
    }

    /*
     * 商品属性修改
     * */
    public function attrUpdate(Request $request)
    {
        $service = new AdminService();

        if($request->isMethod('post')){
            if($service->attrUpdate($request->post())){
                return view('remind.remind',['msg'=>'修改成功!']);
            }else{
                return view('remind.remind',['msg'=>'修改失败!']);
            }
        }
        return view('admin.attr_update',['data'=>$service->attrFind($request->get('id'))->toarray()]);
    }

    /*
     * 商品属性值列表
     * */
    public function attrValList(Request $request)
    {
        $menu_id = $request->get('menu_id');
        $service = new AdminService();
        return view('admin.attrval_list',['data'=>$service->getAttrVal(),'menu_id'=>$menu_id,'button'=>$service->getButton($menu_id)]);
    }

    /*
     * 商品属性值添加
     * */
    public function attrValAdd(Request $request)
    {
        $service = new AdminService();
        if($request->isMethod('post')){
            if($service->attrValAdd($request->post())){
                return view('remind.remind',['msg'=>'添加成功!']);
            }else{
                return view('remind.remind',['msg'=>'添加失败!']);
            }
        }
        return view('admin.attrval_add',['attributes'=>$service->getAllAtrributes()]);
    }

    /*
     * 商品分类添加
     * */
    public function categoryAdd(Request $request)
    {
        $service = new AdminService();

        if($request->isMethod('post')){
            $data = $request->input();
//            dump($data);die;
            $file = $request->file('imgfile');
            if($service->categoryAdd($data,$file)){
                return view('remind.remind',['msg'=>'添加成功!']);
            }else{
                return view('remind.remind',['msg'=>'添加失败!']);
            }
        }

//        dump($service->getAttr());die;

        return view('admin.category_add',['data'=>$service->getCategory(),'attr'=>$service->getAttr()]);
    }

    public function categoryList()
    {
        $menu_id = Input::get('menu_id');
        $service = new AdminService();
        return view('admin.category_list',['data'=>$service->categoryList(),'button'=>$service->getButton($menu_id)]);
    }

    /*
     * 分类修改
     * */
    public function categoryUpdate(Request $request)
    {
        $id = $request->get('id');
        $service = new AdminService();
        if($request->isMethod('post')){
            $file = $request->file('imgfile');
            $data = $request->post();
            if($service->cateUpdate($data,$file)){
                return view('remind.remind',['msg'=>'修改成功!']);
            }else{
                return view('remind.remind',['msg'=>'修改失败!']);
            }
        }
        return view('admin.category_update',['data'=>$service->getCateOne($id),'cate'=>$service->getCategory(),'id'=>$id]);
    }

    public function getCateVal(Request $request)
    {
        $attr_id_arr = $request->post('data',null);
        if(!empty($attr_id_arr)){
            $service = new AdminService();
            return $service->getCateVal($attr_id_arr);
        }else{
            return null;
        }
    }

    public function getOneCate(Request $request)
    {
        $id = $request->get('id');
        if($id == '请选择'){
            return null;
        }
        $service = new AdminService();
        $ids = $service->getCateOne($id)->toarray()['attr_ids'];
        return $service->getAttrIn(explode(',',$ids));
    }

    public function getSku(Request $request)
    {
        $data = $request->post('arr');
        $service = new AdminService();
        $arr = [];
        foreach ($data as $key => $val) {
            $ids = [];
            $val = rtrim($val,')');
            $val = ltrim($val,'(');
            $res = explode(',',$val);
//            print_r($res);
            $arr[] = $service->getAttrValIn($res);
        }


        $str = '';

        foreach ($arr as $k => $v) {
            $name = '';
            $id = '';
            $str .= '<tr>';
            foreach ($v as $value) {
                $name .= $value['val_name'].'/';
                $id .= $value['id'].',';
            }
            $name = rtrim($name,'/');
            $id = rtrim($id,',');
            $str .= '<td>'.$name.'</td><td><input type="text" name="sku_price@'.$name.'" class="sku_price" placeholder="请输入货品价格"></td><td><input name="kc%'.$name.'" type="number" placeholder="请输入库存量"></td>';
            $str .= '</tr>';
        }
        return $str;
    }

}