<?php

use Faker\Generator as Faker;

$factory->define(Dipnet\Business::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'description' => $faker->catchPhrase,
        'user_id' => function () {
            return factory(Dipnet\User::class)->create()->id;
        },
        'company_id' => function () {
            return factory(Dipnet\Company::class)->create()->id;
        },
        'contact_id' => function () {
            return factory(Dipnet\Contact::class)->create()->id;
        }
    ];
});
