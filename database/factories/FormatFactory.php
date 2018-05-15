<?php

use Faker\Generator as Faker;

$factory->define(App\Format::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'height' => $faker->randomNumber($nbDigits = 2, $strict = false),
        'width' => $faker->randomNumber($nbDigits = 2, $strict = false)
    ];
});