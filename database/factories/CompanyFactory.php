<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'status' => 'temporaire',
        'description' => $faker->catchPhrase,
        'business_id' => null,
    ];
});
