<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table='goods';
    protected $primaryKey='goods_id';

    public function getAll()
    {
//        return $this->hasOne('App\Models\Type','t_id','tid');
    }
}
