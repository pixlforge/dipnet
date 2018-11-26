<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'company_name' => $faker->company,
        'address_line1' => $faker->streetName,
        'address_line2' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'phone_number' => $faker->e164PhoneNumber,
        'email' => $faker->companyEmail,
        'user_id' => null,
        'company_id' => null,
    ];
});

$factory->state(App\Contact::class, 'default', [
    'name' => 'default',
    'address_line1' => 'default',
    'address_line2' => null,
    'zip' => 'default',
    'city' => 'default',
    'phone_number' => null,
    'email' => 'default',
    'user_id' => null,
    'company_id' => null,
]);
