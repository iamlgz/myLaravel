<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/26
 * Time: 20:46
 */

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\IndexService;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    /*
     * 渲染首页
     * */
    public function index()
    {
        $service = new IndexService();
        $service->getGoods();
        return view('index.index');
    }

    /*
     * 商品列表
     * */
    public function goodsList()
    {
        return view('index.list');
    }

    /*
     * 渲染商品详细
     * */
    public function goodsDetail()
    {
        return view('index.goods_detail');
    }

    /*
     * 渲染购物车
     * */
    public function shoppingCart()
    {
        return view('index.shopping_cart');
    }

    /*
     * 测试
     * */
    public function test()
    {
        Mail::send('user.login',['name'=>'iamlgz'],function ($message){
            $message->to('1436887468@qq.com')->subject('测试');
        });
    }
}