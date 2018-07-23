<?php

use App\User;
use App\Company;
use App\Contact;
use App\Business;
use Faker\Generator as Faker;
use App\Http\Hashids\HashidsGenerator;

$factory->define(Business::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->company,
        'reference' => HashidsGenerator::generateFor($faker->numberBetween(1, 999), 'businesses'),
        'description' => $faker->catchPhrase,
        'user_id' => null,
        'company_id' => null,
        'contact_id' => null,
    ];
});

$factory->state(Business::class, 'user', function () {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->state(Business::class, 'company', function () {
    return [
        'company_id' => function () {
            return factory(Company::class)->create()->id;
        },
    ];
});

$factory->state(Business::class, 'contact', function () {
    return [
        'contact_id' => function () {
            return factory(Contact::class)->create()->id;
        }
    ];
});
