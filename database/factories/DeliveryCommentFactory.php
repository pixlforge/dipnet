<?php

use Faker\Generator as Faker;

$factory->define(App\DeliveryComment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'delivery_id' => function() {
            return factory(App\Delivery::class)->create()->id;
        },
        'created_by_user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});
