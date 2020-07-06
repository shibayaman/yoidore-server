<?php

namespace App\Http\Requests;

use App\Review;
use App\ReviewDetail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateReview extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'details' => [
                'bail',
                'array',
                'filled',
                'max:5',
                function ($attribute, $details, $fail) {
                    foreach ($details as $detail) {
                        if (!isset($detail['id'])) {
                            $fail('each detail must have id');
                            return;
                        }
                    }
                },
                function ($attribute, $details, $fail) {
                    //'details.*.id' => 'exists:review_detail,id' will send up to 5 queries.
                    //going to send 1 query to get the same result.
                    $review = $this->route('review');
                    $reviewDetails = $review->review_detail;
                    
                    foreach ($details as $detail) {
                        if (!$reviewDetails->contains($detail['id'])) {
                            $fail('selected detail does not belong to the review');
                        }
                    }
                }
            ],
            'details.*.id' => 'distinct',
            'details.*.score' => 'required|integer|max:5',
            'score' => 'integer',
            'tastenote' => 'max:300',
            'best_nibble' => 'max:100',
            'image' => 'nullable'
        ];
    }
}
