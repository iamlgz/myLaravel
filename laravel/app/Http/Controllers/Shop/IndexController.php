<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/26
 * Time: 20:46
 */

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    /*
     * 渲染首页
     * */
    public function index()
    {
        $service = new UserService();
        return view('index.index',['result' => $service->getGoods()]);
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
        $json = file_get_contents("http://ip.taobao.com/service/getIpInfo.php?ip=myip");
        var_dump(json_decode($json)->data);

    }
}