<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleResourse extends Model
{
    //
    protected $table = 'role_resourse';

    public function getSourse($ids)
    {
        return $this->select('select * from role_resourse where '.$ids);
    }
}
