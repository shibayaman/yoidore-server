<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Parameter;
use Faker\Generator as Faker;

$factory->define(Parameter::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'category_id' => 1,
        'name' => $faker->word,
        'description' => $faker->sentence(15)
    ];
});
