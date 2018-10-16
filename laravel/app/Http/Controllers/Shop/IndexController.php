<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/9/26
 * Time: 20:46
 */

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Services\IndexService;
use App\Services\UserService;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    /*
     * 渲染首页
     * */
    public function index()
    {
        $service = new IndexService();
        return view('index.index',['result' => $service->getGoods(),'bottom' => $service->getNavBottom(),'start' => $service->getStartGoods(),'parts' => $service->getParts()]);
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
//        $model = new Menu();
//        var_dump($model->getMenu());
        dump([
            '商城后台管理',
            [
                'text' => 'Blog',
                'url'  => 'admin/blog',
                'can'  => 'manage-blog',
            ],
            [
                'text'        => 'Pages',
                'url'         => 'admin/pages',
                'icon'        => 'file',
                'label'       => 4,
                'label_color' => 'success',
            ],
            'ACCOUNT SETTINGS',
            [
                'text' => 'Profile',
                'url'  => 'admin/settings',
                'icon' => 'user',
            ],
            [
                'text' => 'Change Password',
                'url'  => 'admin/settings',
                'icon' => 'lock',
            ],
            [
                'text'    => 'Multilevel',
                'icon'    => 'share',
                'submenu' => [
                    [
                        'text' => 'Level One',
                        'url'  => '#',
                    ],
                    [
                        'text'    => 'Level One',
                        'url'     => '#',
                        'submenu' => [
                            [
                                'text' => 'Level Two',
                                'url'  => '#',
                            ],
                            [
                                'text'    => 'Level Two',
                                'url'     => '#',
                                'submenu' => [
                                    [
                                        'text' => 'Level Three',
                                        'url'  => '#',
                                    ],
                                    [
                                        'text' => 'Level Three',
                                        'url'  => '#',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'text' => 'Level One',
                        'url'  => '#',
                    ],
                ],
            ],
            'LABELS',
            [
                'text'       => 'Important',
                'icon_color' => 'red',
            ],
            [
                'text'       => 'Warning',
                'icon_color' => 'yellow',
            ],
            [
                'text'       => 'Information',
                'icon_color' => 'aqua',
            ],
        ]);
    }
}