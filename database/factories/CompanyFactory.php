<?php

use Faker\Generator as Faker;

$factory->define(Dipnet\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status' => 'temporaire',
        'description' => $faker->catchPhrase,
        'created_by_username' => $faker->userName,
    ];
});