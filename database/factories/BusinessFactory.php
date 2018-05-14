<?php

use Faker\Generator as Faker;

$factory->define(App\Business::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'description' => $faker->catchPhrase,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Company::class)->create()->id;
        },
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        }
    ];
});
