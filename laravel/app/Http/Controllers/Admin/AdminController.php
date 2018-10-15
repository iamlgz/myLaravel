<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/15
 * Time: 14:30
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}