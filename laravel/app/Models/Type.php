<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table='type';
    protected $primaryKey='t_id';

    public function getAll()
    {
        return $this->get()->toArray();
    }
}
