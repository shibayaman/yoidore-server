<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Review;
use Auth;

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
}
