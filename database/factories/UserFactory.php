<?php

use App\User;
use App\Company;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'email' => $faker->unique()->safeEmail,
        'company_id' => function () {
            return factory(Company::class)->create()->id;
        },
        'is_solo' => false,
        'email_confirmed' => true,
        'contact_confirmed' => true,
        'company_confirmed' => true,
        'confirmation_token' => null,
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'not-confirmed', function (Faker $faker) {
    return [
        'email_confirmed' => false,
        'contact_confirmed' => false,
        'company_confirmed' => false,
        'confirmation_token' => User::generateConfirmationToken($faker->safeEmail),
    ];
});

$factory->state(User::class, 'email-not-confirmed', function (Faker $faker) {
    return [
        'email_confirmed' => false,
        'confirmation_token' => User::generateConfirmationToken($faker->safeEmail),
    ];
});

$factory->state(User::class, 'contact-not-confirmed', [
    'contact_confirmed' => false,
]);

$factory->state(User::class, 'company-not-confirmed', [
    'company_confirmed' => false,
]);

$factory->state(User::class, 'mailable-tests-only', [
    'company_id' => 1,
]);

$factory->state(User::class, 'no-company', [
    'company_id' => null,
]);

$factory->state(User::class, 'admin', [
    'role' => 'administrateur',
]);

$factory->state(User::class, 'user', [
    'role' => 'utilisateur',
]);

$factory->state(User::class, 'solo', [
    'is_solo' => true,
    'company_id' => null,
]);
