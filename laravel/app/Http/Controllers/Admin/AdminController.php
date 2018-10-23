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
use App\Services\IndexService;
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

}