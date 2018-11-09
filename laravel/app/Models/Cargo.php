<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    protected $table = 'cargo';

    public function addCargo($data)
    {
        return self::insert($data);
    }

    public function getData($goods_id)
    {
        return self::where(['goods_id'=>$goods_id])->get()->toArray();
    }
}
