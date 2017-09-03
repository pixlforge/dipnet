<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'role' => $faker->randomElement(['utilisateur', 'administrateur']),
        'email' => $faker->unique()->safeEmail,
        'email_validated' => false,
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Company::class)->create()->id;
        },
        'remember_token' => str_random(10),
    ];
});