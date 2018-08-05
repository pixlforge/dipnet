<?php

use App\Order;
use App\Contact;
use App\Delivery;
use Faker\Generator as Faker;
use App\Http\Hashids\HashidsGenerator;

$factory->define(Delivery::class, function (Faker $faker) {
    return [
        'reference' => HashidsGenerator::generateFor($faker->numberBetween(1, 999999999), 'deliveries'),
        'note' => null,
        'admin_note' => null,
        'order_id' => function () {
            return factory(Order::class)->create()->id;
        },
        'contact_id' => null,
        'to_deliver_at' => null,
        'deleted_at' => null
    ];
});

$factory->state(Delivery::class, 'add-contact', function () {
    return [
        'contact_id' => function () {
            return factory(Contact::class)->create()->id;
        },
    ];
});

$factory->state(Delivery::class, 'add-delivery-date', function () {
    return [
        'to_deliver_at' => now()->addWeeks(2),
    ];
});
