<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table='category';
    protected $primaryKey='c_id';

    public function getAll()
    {
        return $this->get()->toArray();
    }
}
