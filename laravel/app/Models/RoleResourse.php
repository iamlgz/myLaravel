<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleResourse extends Model
{
    //
    protected $table = 'role_resourse';

    public function changePower($id,$arr)
    {
        $resourse = $this->where(['role_id'=>$id,'type'=>0])->get();
        if(empty($resourse->toArray())){
            return $this->insert($arr);
        }else{
            if($this->where(['role_id'=>$id,'type'=>0])->delete() && $this->insert($arr)){
                return true;
            }
        }
    }

}
