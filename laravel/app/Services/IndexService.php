<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/8
 * Time: 10:57
 */

namespace App\Services;


use App\Models\Goods;
use App\Models\User;

class IndexService
{
    public function getUserById($id)
    {
        $model = new User();
        return $model->getInfoById($id)['username'];
    }

    /*
     * 获取商品分类及数据
     * */
    public function getGoods()
    {
        $goodsModel = new Goods();
        var_dump($goodsModel->getAll());die();
    }
}