<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'role' => 'utilisateur',
        'email' => $faker->unique()->safeEmail,
        'company_id' => function () {
            return factory(App\Company::class)->create()->id;
        },
        'email_confirmed' => true,
        'contact_confirmed' => true,
        'company_confirmed' => true,
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'not-confirmed', [
    'email_confirmed' => false,
    'contact_confirmed' => false,
    'company_confirmed' => false
]);

$factory->state(App\User::class, 'email-not-confirmed', [
    'email_confirmed' => false
]);

$factory->state(App\User::class, 'contact-not-confirmed', [
    'contact_confirmed' => false
]);

$factory->state(App\User::class, 'company-not-confirmed', [
    'company_confirmed' => false
]);

$factory->state(App\User::class, 'mailable-tests-only', [
    'company_id' => 1,
]);

$factory->state(App\User::class, 'no-company', [
    'company_id' => null,
]);