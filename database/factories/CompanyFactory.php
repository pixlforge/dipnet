<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'slug' => function ($company) {
            return str_slug($company['name']);
        },
        'status' => 'temporaire',
        'description' => $faker->catchPhrase,
        'business_id' => null,
    ];
});
