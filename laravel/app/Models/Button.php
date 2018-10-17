<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Button extends Model
{
    protected $table = 'button';

    public function getButton($menu_id,$admin_id = 0)
    {
       return DB::select("SELECT * FROM button WHERE id in (SELECT resourse_id FROM role_resourse where role_id in (SELECT role_id FROM user_role WHERE admin_id=$admin_id) AND type=1) and menu_id=$menu_id");
    }

    public function getAll($menu_id)
    {
        return $this->where(['menu_id'=>$menu_id])->get(['button_id']);
    }
}
