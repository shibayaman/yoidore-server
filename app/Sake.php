<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sake extends Model
{
    protected $fillable = ['category_id', 'name'];
    
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function review()
    {
        return $this->hasMany('App\Review');
    }
}
