<?php

namespace App\Http\Requests;

use App\Parameter;
use App\ReviewDetail;
use App\Sake;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreReview extends FormRequest
{
    public function authorize(Request $request)
    {
        return true;
    }

    public function rules(Request $request)
    {
        return [
            'sake_id' => [
                'required',
                'exists:sakes,id',
                Rule::unique('reviews')->where(function ($query) {
                    $query->where('user_id', $this->user()->id);
                })
            ],
            'details' => [
                'bail',
                'array',
                'filled',
                'max:5',
                function ($attribute, $details, $fail) {
                    //check if each detail has parameter_id property
                    foreach ($details as $detail) {
                        if (!isset($detail['parameter_id'])) {
                            $fail('each detail must have parameter_id');
                            return;
                        }
                    }
                },
                function ($attribute, $details, $fail) use ($request) {
                    /*
                    it should check if each parameter_id in details exists in the database
                        but adding 'exists' validation to 'details.*.parameter_id' will send as many query as count(details).
                    it should also check if $review_detail->parameter->category_id matches $sake->category_id
                        and review_detail->parameter->user_id matches $user->id
                    validating the above 3 rules separately is ideal but will triger unnecessary amount of queries.
                    attempt to validate all of the above in this function with 1 query.
                    */

                    $parameter_ids = [];
                    foreach ($details as $detail) {
                        $parameter_ids[] = $detail['parameter_id'];
                    }

                    $parameters = Parameter::whereIn('id', $parameter_ids)->get();
                    if ($parameters->count() !== count($details)) {
                        $fail('parameter_id in details not found in database');
                    }

                    $sake = Sake::where('id', $request->input('sake_id'))->first();
                    foreach ($parameters as $parameter) {
                        if ($sake && $parameter->category_id !== $sake->category_id) {
                            $fail('mismatch in detail parameter_id and sake_id');
                            return;
                        }

                        //should be done in authrize method and return 403...
                        if ($parameter->user_id !== $this->user()->id) {
                            $fail('parameter does not belong to current user');
                            return;
                        }
                    }
                }
            ],
            'details.*.score' => 'required|integer|max:5',
            'score' => 'required|integer',
            'tastenote' => 'required|max:300',
            'best_nibble' => 'required|max:100',
            'image' => 'nullable'
        ];
    }
}
