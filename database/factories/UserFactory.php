<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'role' => 'utilisateur',
        'email' => $faker->unique()->safeEmail,
        'confirmed' => true,
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Company::class)->create()->id;
        },
        'contact_confirmed' => true,
        'company_confirmed' => true,
        'was_invited' => false,
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'not-confirmed', [
    'confirmed' => false,
    'contact_confirmed' => false,
    'company_confirmed' => false
]);

$factory->state(App\User::class, 'email-not-confirmed', [
    'confirmed' => false
]);

$factory->state(App\User::class, 'contact-not-confirmed', [
    'contact_confirmed' => false
]);

$factory->state(App\User::class, 'company-not-confirmed', [
    'company_confirmed' => false
]);

$factory->state(App\User::class, 'mailable-tests-only', [
    'contact_id' => 1,
    'company_id' => 1,
]);