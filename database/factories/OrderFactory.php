<?php

use App\User;
use App\Order;
use App\Contact;
use App\Business;
use Faker\Generator as Faker;
use App\Http\Hashids\HashidsGenerator;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'reference' => HashidsGenerator::generateFor($faker->numberBetween(1, 999999999), 'orders'),
        'status' => 'incomplète',
        'business_id' => null,
        'contact_id' => null,
        'user_id' => null,
    ];
});

$factory->state(Order::class, 'sent', function () {
    return [
        'status' => 'envoyée',
    ];
});

$factory->state(Order::class, 'add-business', function () {
    return [
        'business_id' => function () {
            return factory(Business::class)->create()->id;
        },
    ];
});

$factory->state(Order::class, 'add-contact', function () {
    return [
        'contact_id' => function () {
            return factory(Contact::class)->create()->id;
        },
    ];
});

$factory->state(Order::class, 'add-user', function () {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
