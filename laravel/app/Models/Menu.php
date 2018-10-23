<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';

    /*
     * 查询菜单
     * */
    public function getMenu()
    {
        return self::all()->toArray();
    }
}
