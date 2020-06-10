<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ReviewDetail;
use Faker\Generator as Faker;

$factory->define(ReviewDetail::class, function (Faker $faker) {
    return [
        'parameter_id' => 1,
        'review_id' => 1,
        'score' => rand(1, 5)
    ];
});
