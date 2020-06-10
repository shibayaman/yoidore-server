<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sake;
use Faker\Generator as Faker;

$factory->define(Sake::class, function (Faker $faker) {
    return [
        'category_id' => 1,
        'name' => $faker->word,
        'image_url' => 'http://placecorgi.com/250'
    ];
});
