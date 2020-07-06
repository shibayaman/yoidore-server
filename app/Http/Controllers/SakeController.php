<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSake;
use App\Sake;

class SakeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

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

    public function store(StoreSake $request)
    {
        $sake = Sake::create($request->validated());
        return $sake;
    }
}
