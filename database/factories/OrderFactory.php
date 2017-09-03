<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'status' => $faker->randomElement(['ok', 'nok']),
        'business_id' => function() {
            return factory(App\Business::class)->create()->id;
        },
        'contact_id' => function() {
            return factory(App\Contact::class)->create()->id;
        },
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});
