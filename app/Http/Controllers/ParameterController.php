<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParameter;
use App\Parameter;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;

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

    public function store(StoreParameter $request)
    {
        $categoryId = $request->input('category_id');

        foreach ($request->input('parameters') as $parameter) {
            $parameterDatas[] = [
                'user_id' => Auth::user()->id,
                'category_id' => $request->input('category_id'),
                'name' => $parameter['name'],
                'description' => $parameter['description'] ?? ''
            ];
        }

        //insertGetId method can do bulk insert but only returns final inserted id.
        //going to send up to 5 insert queries in order to return all the inserted models with their id.
        $parameters = DB::transaction(function () use ($parameterDatas) {
            foreach ($parameterDatas as $parameterData) {
                $parameters[] = Parameter::create($parameterData);
            }
            return $parameters;
        });

        return $parameters;
    }
}
