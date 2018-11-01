<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttrVal extends Model
{
    //
    protected $table = 'attr_val';

    public function getAll()
    {
        return self::join('attributes','attr_val.attr_id','=','attributes.id')->paginate(10);
    }

    public function attrValAdd($data)
    {
        return self::insert($data);
    }

    public function getAttrVal($ids)
    {
        return self::whereIn('attr_id',$ids)->get();
    }

    public function getAttrValIn($ids)
    {
        return self::whereIn('id',$ids)->get();
    }
}
