<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    do {
        $mimeType = $faker->mimeType;
    } while(strlen($mimeType) > 45);

    return [
        'filename' => $fileName = $faker->isbn13 . '.' . $faker->fileExtension,
        'mime_type' => $mimeType,
        'size' => $faker->randomNumber(6, false),
        'quantity' => $faker->numberBetween($min = 1, $max = 100),
        'finish' => $faker->randomElement(['roulé', 'plié']),
        'format_id' => function() {
            return factory(App\Format::class)->create()->id;
        },
        'delivery_id' => function() {
            return factory(App\Delivery::class)->create()->id;
        },
        'article_id' => function() {
            return factory(App\Article::class)->create()->id;
        },
    ];
});
