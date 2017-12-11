<?php

use Faker\Generator as Faker;

$factory->define(Dipnet\Order::class, function (Faker $faker) {
    return [
        'reference' => uniqid(),
        'status' => $faker->randomElement(['ok', 'nok']),
        'business_id' => function() {
            return factory(Dipnet\Business::class)->create()->id;
        },
        'contact_id' => function() {
            return factory(Dipnet\Contact::class)->create()->id;
        },
        'user_id' => function() {
            return factory(Dipnet\User::class)->create()->id;
        },
    ];
});
