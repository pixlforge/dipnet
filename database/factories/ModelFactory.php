<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->unique()->userName,
        'password' => $password ?: $password = bcrypt('secret'),
        'role' => $faker->randomElement(['user', 'admin']),
        'email' => $faker->unique()->safeEmail,
        'email_validated' => true,
        'contact_id' => function () {
            return factory(App\Contact::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Company::class)->create()->id;
        },
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Company::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'status' => $faker->randomElement(['temp', 'perm']),
        'description' => $faker->catchPhrase,
        'created_by_username' => $faker->userName,
    ];
});

$factory->define(App\Contact::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->domainWord,
        'address_line1' => $faker->streetName,
        'address_line2' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'phone_number' => $faker->e164PhoneNumber,
        'fax' => $faker->e164PhoneNumber,
        'email' => $faker->companyEmail,
        'company_id' => function() {
            return factory(App\Company::class)->create()->id;
        },
        'created_by_username' => $faker->userName,
    ];
});

$factory->define(App\Format::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->domainWord,
        'height' => $faker->randomNumber($nbDigits = 2, $strict = false),
        'width' => $faker->randomNumber($nbDigits = 2, $strict = false),
        'surface' => $faker->randomNumber($nbDigits = 4, $strict = false),
    ];
});

$factory->define(App\Category::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->colorName,
    ];
});

$factory->define(App\Business::class, function(Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company,
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'description' => $faker->catchPhrase,
        'company_id' => function() {
            return factory(App\Company::class)->create()->id;
        },
        'main_contact_id' => function() {
            return factory(App\Contact::class)->create()->id;
        },
        'created_by_username' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Order::class, function(Faker\Generator $faker) {
    return [
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'status' => $faker->randomElement(['ok', 'nok']),
        'business_id' => function() {
            return factory(App\Business::class)->create()->id;
        },
        'billing_contact_id' => function() {
            return factory(App\Contact::class)->create()->id;
        },
        'created_by_user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Article::class, function(Faker\Generator $faker) {
    return [
        'reference' => $faker->randomNumber($nbDigits = 8, $strict = false),
        'type' => $faker->randomElement(['impression', 'option']),
        'category_id' => function() {
            return factory(App\Category::class)->create()->id;
        },
    ];
});

$factory->define(App\BusinessComment::class, function(Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'business_id' => function() {
            return factory(App\Business::class)->create()->id;
        },
        'created_by_user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\DeliveryComment::class, function(Faker\Generator $faker) {
    return [
        'content' => $faker->paragraph,
        'delivery_id' => function() {
            return factory(App\Delivery::class)->create()->id;
        },
        'created_by_user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
    ];
});

$factory->define(App\Delivery::class, function() {
    return [
        'order_id' => function() {
            return factory(App\Order::class)->create()->id;
        },
        'delivery_contact_id' => function() {
            return factory(App\Contact::class)->create()->id;
        },
    ];
});

$factory->define(App\Document::class, function(Faker\Generator $faker) {

    do {
        $mimeType = $faker->mimeType;
    } while(strlen($mimeType) > 45);

    return [
        'file_name' => $fileName = $faker->isbn13 . '.' . $faker->fileExtension,
        'file_path' => '/path/to/file/',
        'mime_type' => $mimeType,
        'quantity' => $faker->numberBetween($min = 1, $max = 100),
        'rolled_folded_flat' => $faker->randomElement(['rolled', 'folded', 'flat']),
        'length' => $faker->numberBetween($min = 1, $max = 100),
        'width' => $faker->numberBetween($min = 1, $max = 100),
        'nb_orig' => $faker->numberBetween($min = 1, $max = 6),
        'free' => $faker->randomElement([0, 1]),
        'format_id' => function() {
            return factory(App\Format::class)->create()->id;
        },
        'delivery_id' => function() {
            return factory(App\Delivery::class)->create()->id;
        },
        'main_article_id' => function() {
            return factory(App\Article::class)->create()->id;
        },
    ];
});
