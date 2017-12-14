<?php

use Faker\Generator as Faker;

$factory->define(Dipnet\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status' => 'temporaire',
        'description' => $faker->catchPhrase,
        'business_id' => null,
        'created_by_username' => $faker->userName,
    ];
});