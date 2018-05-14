<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'description' => $faker->word,
        'type' => $faker->randomElement(['impression', 'option']),
        'greyscale' => array_random([true, false])
    ];
});
