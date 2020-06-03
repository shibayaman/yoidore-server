<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Parameter;

class ParameterController extends Controller
{
    public function index()
    {
        return Parameter::all();
    }
}
