<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewDetail extends Model
{
    public function review()
    {
        return $this->belongsTo('App\Review');
    }
    
    public function parameter()
    {
        return $this->belongsTo('App\Parameter');
    }
}
