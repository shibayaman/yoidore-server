<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description'
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function review_detail()
    {
        return $this->hasMany('App\ReviewDetail');
    }
}
