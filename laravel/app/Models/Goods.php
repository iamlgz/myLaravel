<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table='goods';
    protected $primaryKey='goods_id';

    public function getAll()
    {
        return $this->get()->toArray();
    }

    public function getTypeAndGoods()
    {
        return $this->join('category','goods.cid','=','category.c_id')->paginate(10);
    }

    public function addGoods($data)
    {
        return self::insertGetId($data);
    }

    public function getOne($id)
    {
        return self::find($id);
    }

}
