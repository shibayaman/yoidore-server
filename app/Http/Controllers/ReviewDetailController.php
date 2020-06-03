<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReviewDetail;

class ReviewDetailController extends Controller
{
    public function index()
    {
        return ReviewDetail::all();
    }
}
