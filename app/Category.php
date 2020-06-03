<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function sake()
    {
        return $this->hasMany('App\Sake');
    }

    public function parameter()
    {
        return $this->hasMany('App\Parameter');
    }
}
