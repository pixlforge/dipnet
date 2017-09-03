<?php

use Faker\Generator as Faker;

$factory->define(App\Document::class, function (Faker $faker) {
    do {
        $mimeType = $faker->mimeType;
    } while(strlen($mimeType) > 45);

    return [
        'file_name' => $fileName = $faker->isbn13 . '.' . $faker->fileExtension,
        'file_path' => '/path/to/file/',
        'mime_type' => $mimeType,
        'quantity' => $faker->numberBetween($min = 1, $max = 100),
        'rolled_folded_flat' => $faker->randomElement(['roulé', 'plié']),
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
        'article_id' => function() {
            return factory(App\Article::class)->create()->id;
        },
    ];
});
