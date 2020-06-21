<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReviewDetail;
use App\Review;
use Auth;

class ReviewDetailController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $reviewId = $request->query('review_id');
        abort_if(!$reviewId, 400, 'review_id must be specified');

        $review = Review::find($reviewId);
        if (!$review) {
            return [];
        }

        $this->authorize('view', $review);
        $reviewDetails = ReviewDetail::where('review_id', $review->id)->get();
        return $reviewDetails;
    }
}
