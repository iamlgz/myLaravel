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

    public function adminAdd()
    {
        return view('admin.admin_add');
    }

    public function operationGoods()
    {
        $menu_id = Input::get('menu_id');
        $service = new AdminService();
        return view('admin.goods_admin',['data' => $service->getGoods(),'button'=>$service->getButton($menu_id),'menu_id'=>$menu_id]);
    }

}