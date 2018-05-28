<?php

use Faker\Generator as Faker;

$factory->define(App\Ticker::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'active' => false
    ];
});

$factory->state(App\Ticker::class, 'active', function () {
    return [
        'active' => true
    ];
});
