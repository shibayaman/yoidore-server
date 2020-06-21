<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parameter;
use Auth;

class ParameterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        abort_if(!$categoryId, 400, 'category_id must be specified');

        $user = Auth::user();
        $parameters = Parameter::where([
            'user_id' => $user->id,
            'category_id' => $categoryId
        ])->get();

        return $parameters;
    }
}
