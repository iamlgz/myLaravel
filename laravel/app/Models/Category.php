<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    //
    protected $table = 'category';
    protected $primaryKey = 'c_id';

    public $timestamps = false;

    public function getCategory()
    {
        return self::where(['pid'=>0])->get();

//        return DB::select("SELECT CONCAT(path,'-',c_id) as a,c_name,c_id,path FROM category ORDER BY a");
    }

    public function addCategory($data)
    {
        return self::insert($data);
    }

    public function categoryList()
    {
        return DB::select("SELECT CONCAT(path,'-',c_id) as a,c_name,c_id,url,img FROM category ORDER BY a");
    }

    public function getOne($id)
    {
        return self::where(['c_id'=>$id])->first();
    }

    public function cateUpdate($id,$arr)
    {
        return self::where(['c_id'=>$id])->update($arr);
    }

    public function getCate()
    {
        return DB::select("SELECT CONCAT(path,'-',c_id) as a,c_name,c_id,path,attr_ids FROM category ORDER BY a");
    }

//    public function getIn($ids)
//    {
//        return self::whereIn('id',$ids)->get()->toarray();
//    }

    public function cateFind($id)
    {
        return self::find($id);
    }

}
