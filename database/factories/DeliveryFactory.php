<?php

use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Dipnet\Delivery::class, function (Faker $faker) {
    return [
        'reference' => uniqid(),
        'note' => null,
        'order_id' => function() {
            return factory(Dipnet\Order::class)->create()->id;
        },
        'contact_id' => function() {
            return factory(Dipnet\Contact::class)->create()->id;
        },
        'to_deliver_at' => Carbon::now()->addWeeks(2),
        'deleted_at' => null
    ];
});