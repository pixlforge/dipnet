<?php

use App\User;
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
//        'confirmation_token' => User::generateConfirmationToken($faker->safeEmail),
        'confirmation_token' => null,
        'remember_token' => str_random(10),
    ];
});

$factory->state(App\User::class, 'not-confirmed', function (Faker $faker) {
    return [
        'email_confirmed' => false,
        'contact_confirmed' => false,
        'company_confirmed' => false,
        'confirmation_token' => User::generateConfirmationToken($faker->safeEmail)
    ];
});

$factory->state(App\User::class, 'email-not-confirmed', function (Faker $faker) {
    return [
        'email_confirmed' => false,
        'confirmation_token' => User::generateConfirmationToken($faker->safeEmail)
    ];
});

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

$factory->state(App\User::class, 'admin', [
    'role' => 'administrateur'
]);