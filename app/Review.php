<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Review extends Model
{
    protected $fillable = [
        'sake_id',
        'user_id',
        'score',
        'image_url',
        'tastenote',
        'best_nibble'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sake()
    {
        return $this->belongsTo('App\Sake');
    }

    public function review_detail()
    {
        return $this->hasMany('App\ReviewDetail');
    }

    public function insertReviewDetails(array $review_details)
    {
        $detailsWithReviewId = [];

        foreach ($review_details as $review_detail) {
            $detailsWithReviewId[] = array_merge($review_detail, [
                'review_id' => $this->getKey(),
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ]);
        }

        ReviewDetail::insert($detailsWithReviewId);
    }

    public function updateReviewDetails(array $review_details)
    {
        foreach ($review_details as $review_detail) {
            $newReviewDetail = $this->review_detail->find($review_detail['id']);
            $newReviewDetail->score = $review_detail['score'];
            $newReviewDetail->save();
        }
    }
}
