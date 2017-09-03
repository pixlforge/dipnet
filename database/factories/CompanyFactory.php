<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status' => $faker->randomElement(['temporaire', 'permanent']),
        'description' => $faker->catchPhrase,
        'created_by_username' => $faker->userName,
    ];
});