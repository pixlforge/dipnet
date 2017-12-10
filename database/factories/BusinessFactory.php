<?php

use Faker\Generator as Faker;

$factory->define(Dipnet\Business::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'description' => $faker->catchPhrase,
        'company_id' => function() {
            return factory(Dipnet\Company::class)->create()->id;
        },
        'contact_id' => function() {
            return factory(Dipnet\Contact::class)->create()->id;
        },
        'created_by_username' => function() {
            return factory(Dipnet\User::class)->create()->username;
        },
    ];
});
