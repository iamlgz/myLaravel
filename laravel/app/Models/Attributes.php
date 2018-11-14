<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attributes extends Model
{
    //
    protected $table = 'attributes';
    public $timestamps = false;

    public function getAll()
    {
        return self::paginate(10);
    }

    public function attrAdd($data)
    {
        return self::insert($data);
    }

    public function attrFind($id)
    {
        return self::find($id);
    }

    public function attrUpdate($id,$arr)
    {
        return self::where(['id'=>$id])->update($arr);
    }

    public function getAllAtrributes()
    {
        return self::get()->toarray();
    }

    public function getIn($ids)
    {
        return self::whereIn('id',$ids)->get();
    }
}
