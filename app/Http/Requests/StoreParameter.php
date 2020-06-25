<?php

namespace App\Http\Requests;

use App\Category;
use App\Parameter;
use App\Rules\AllUnique;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreParameter extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(Request $request)
    {
        $user = $this->user();
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'parameters' => [
                'required',
                'array',
                'max:5',
                function ($attribute, $value, $fail) use ($request, $user) {
                    $count = Parameter::where([
                        'user_id' => $user->id,
                        'category_id' => $request->input('category_id')
                    ])->count();
                    
                    $namesCount = count($request->input('parameters'));

                    if ($count + $namesCount > 5) {
                        $fail('too many' . $attribute);
                    }
                },
            ],
            'parameters.*.name' => [
                'required',
                'string',
                'max:100',
                'distinct',
                Rule::unique('parameters')->where(function ($query) use ($request, $user) {
                    $query->where([
                        'user_id' => $user->id,
                        'category_id' => $request->input('category_id')
                    ]);
                })
            ],
            'parameters.*.description' => 'string|max:255'
        ];
    }
}
