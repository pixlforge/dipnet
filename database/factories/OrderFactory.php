<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'reference' => uniqid(),
        'status' => 'incomplète',
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
