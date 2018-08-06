<?php

use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'width' => null,
        'height' => null,
        'nb_orig' => null,
        'quantity' => $faker->numberBetween($min = 1, $max = 100),
        'finish' => $faker->randomElement(['roulé', 'plié']),
        'delivery_id' => function () {
            return factory(App\Delivery::class)->create()->id;
        },
        'article_id' => function () {
            return factory(App\Article::class)->create()->id;
        },
    ];
});
