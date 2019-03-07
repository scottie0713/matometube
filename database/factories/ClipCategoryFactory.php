<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ClipCategory::class, function (Faker $faker) {
    return [
        'clip_id'   => $faker->randomNumber(),
        'name'      => $faker->word,
    ];
});
