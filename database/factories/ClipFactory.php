<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Clip::class, function (Faker $faker) {
    return [
        'title'     => 'test',
        'author'     => '管理人',
        'password'   => md5('password'),
    ];
});