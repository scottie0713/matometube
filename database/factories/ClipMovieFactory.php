<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ClipMovie::class, function (Faker $faker) {
    return [
        'clip_id'           => $faker->randomNumber(),
//        'platform'           => $faker->randomElement($array = ['youtube', 'nicovideo']),
        'platform'           => $faker->randomElement($array = ['nicovideo']),
        'movie_id'          => 'sm9',
    ];
});
