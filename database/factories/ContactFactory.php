<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    return [
        'name' => $faker->domainWord,
        'address_line1' => $faker->streetName,
        'address_line2' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'phone_number' => $faker->e164PhoneNumber,
        'fax' => $faker->e164PhoneNumber,
        'email' => $faker->companyEmail,
        'company_id' => null,
        'created_by_username' => $faker->userName,
    ];
});

$factory->state(App\Contact::class, 'default', [
    'name' => 'default',
    'address_line1' => 'default',
    'address_line2' => null,
    'zip' => 'default',
    'city' => 'default',
    'phone_number' => 'default',
    'fax' => 'default',
    'email' => 'default',
    'company_id' => null,
    'created_by_username' => 'default',
]);