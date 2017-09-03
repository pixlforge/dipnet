<?php

use Faker\Generator as Faker;

$factory->define(App\Delivery::class, function (Faker $faker) {
    return [
        'order_id' => function() {
            return factory(App\Order::class)->create()->id;
        },
        'contact_id' => function() {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});
