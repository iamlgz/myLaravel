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
        }
        return view('admin.login');
    }
}