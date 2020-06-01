<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sake;

class SakeController extends Controller
{
    public function index()
    {
        return Sake::all();
    }

    public function show($id)
    {
        return Sake::find($id);
    }
}
