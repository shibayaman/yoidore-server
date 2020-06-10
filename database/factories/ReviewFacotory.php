<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Review;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'sake_id' => 1,
        'score' => rand(1, 5),
        'tastenote' => $faker->sentence(15),
        'best_nibble' => $faker->word
    ];
});
