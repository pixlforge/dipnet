<?php

use Faker\Generator as Faker;

$factory->define(App\BusinessComment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'business_id' => function() {
            return factory(App\Business::class)->create()->id;
        },
        'created_by_user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});
