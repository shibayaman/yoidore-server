<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReview;
use App\Http\Requests\UpdateReview;
use App\Review;
use App\ReviewDetail;
use Auth;
use DB;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('publicNotes');
    }

    public function index()
    {
        $user = Auth::user();
        return Review::where('user_id', $user->id)->get();
    }

    public function show(Review $review)
    {
        $this->authorize('view', $review);
        return $review;
    }

    public function publicNotes()
    {
        //酒ごとのコメント、パブリックなものだけ
    }

    public function store(StoreReview $request)
    {
        $reviewData = $request->validated();

        $reviewData['user_id'] = Auth::id();

        // if($reviewData->hasFile('image')) {
        //     save image
        // }

        $reviewData['image_url'] = 'noimage.jpg';

        $review = DB::transaction(function () use ($reviewData) {
            $review = Review::create($reviewData);
            $review->insertReviewDetails($reviewData['details']);

            return $review;
        });
       
        return $review;
    }

    public function update(UpdateReview $request, Review $review)
    {
        $validated = $request->validated();
        $review->fill($validated);

        // if($validated->hasFile('image')) {
        //     save image
        // }

        if (isset($validated['details'])) {
            $review->updateReviewDetails($validated['details']);
        }

        return $review;
    }
}
