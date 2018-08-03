<?php

use App\User;
use App\Comment;
use App\Business;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text(),
        'business_id' => function () {
            return factory(Business::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
