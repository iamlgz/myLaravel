<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    //
    protected $table = 'promotion';

    /*
     * 导航下商品列表
     * */
    public function getNavBottom()
    {
        return $this->where(['position' => 'navbottom'])->get(['goods_id','type','img','url'])->toArray();
    }

    /*
     * 小米明星单品
     * */
    public function getStartGoods()
    {
        return $this->join('goods','promotion.goods_id','=','goods.goods_id')->where(['position' => 'startgoods'])->get(['promotion.goods_id','promotion.describe','promotion.img','goods.goods_price','goods.goods_name'])->toArray();
    }

    /*
     * 获取配件商品
     * */
    public function getParts()
    {
        return $this->leftJoin('goods','promotion.goods_id','=','goods.goods_id')->where(['position' => 'parts'])->get(['promotion.goods_id','promotion.type','promotion.describe','promotion.img','goods.goods_price','goods.goods_name','goods.goods_ms','promotion.url'])->toArray();
    }
}
