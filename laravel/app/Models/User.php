<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    protected $table='user';

    public function select()
    {
        $data=DB::table('user')->get()->toArray();
        return $data;
    }
}
