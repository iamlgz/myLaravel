<?php
/**
 * Created by PhpStorm.
 * User: 好看
 * Date: 2018/10/12
 * Time: 10:17
 */

namespace App\Services;

use App\Models\Cargo;
use App\Models\Goods;
use App\Models\Menu;
use App\Models\Type;
use App\Models\Promotion;
use Illuminate\Support\Facades\Redis;



class IndexService
{
    /*
 * 获取商品分类及数据
 * */
    public function getGoods()
    {
        $goodsModel = new Goods();
        $typeModel = new Type();
//        $data = Redis::get('result');
        if(empty($data)){
            $allGoods = $goodsModel->getAll();
            $allTyoe = $typeModel->getAll();
            $result = $this->classify($allTyoe,$allGoods);
//            Redis::set('result',serialize($result));
        }else{
            $result = unserialize($data);
        }
        return $result;
    }

    /*
     * 分类对应商品
     * */
    public function classify($type,$goods)
    {
        foreach ($type as $k => $v) {
            $i=0;
            foreach ($goods as $key => $val) {
                if($v['c_id']==$val['cid']){
                    ++$i;
                    if ($i <= 6){
                        $type[$k]['left'][] = $val;
                    }elseif ($i > 6 && $i <= 12){
                        $type[$k]['center'][] = $val;
                    }elseif ($i > 12 && $i <= 18){
                        $type[$k]['right'][] = $val;
                    }
                }
            }
        }
        return $type;
    }

    /*
     * 获取导航下商品
     * */
    public function getNavBottom()
    {
        $model = new Promotion();
        $data = $model->getNavBottom();
        $arr=[];
        foreach ($data as $key => $value) {
            if($value['type'] == 'service'){
                $arr['service'][] = $value;
            }else{
                $arr['goods'][] = $value;
            }
        }
        return $arr;
    }

    /*
     * 获取小米明星单品
     * */
    public function getStartGoods()
    {
        $model = new Promotion();
        return $model->getStartGoods();
    }

    /*
     * 获取配件商品
     * */
    public function getParts()
    {
        $model = new Promotion();
        $data = $model->getParts();
        $arr = [];
        foreach ($data as $k => $v) {
            if($k <= 4){
                $arr['top'][] = $v;
            }elseif($v['type'] == 'last'){
                $arr['last'][] = $v;
            }else{
                $arr['bottom'][] = $v;
            }
        }
        return $arr;
    }

    /*
     * 商品详细
     * */
    public function getGoodsDetail($id)
    {
        $goodsModel = new Goods();
        return $goodsModel->getOne($id);
    }

    public function getSku($id)
    {
        $model = new Cargo();
        return $model->getData($id);
    }
}