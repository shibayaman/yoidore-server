<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sake;

class SakeController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');

        if ($categoryId) {
            return Sake::where('category_id', $categoryId)->get();
        }

        return Sake::all();
    }

    public function show(Sake $sake)
    {
        return $sake;
    }
}
