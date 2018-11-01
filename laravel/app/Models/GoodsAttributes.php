<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsAttributes extends Model
{
    //
    protected $table = 'goods_attributes';

    public function addGoodsAttr($data)
    {
        return self::insert($data);
    }

}
