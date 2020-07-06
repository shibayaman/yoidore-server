<?php

namespace App\Http\Requests;

use App\Parameter;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParameter extends FormRequest
{
    public function authorize()
    {
        $parameter = $this->route('parameter');
        return $parameter && $this->user()->can('update', $parameter);
    }

    public function rules()
    {
        return [
            'name' => 'max:100',
            'description' => 'max:255'
        ];
    }
}
