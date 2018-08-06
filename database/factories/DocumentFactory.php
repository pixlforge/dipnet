<?php

use App\Article;
use App\Delivery;
use App\Document;
use Faker\Generator as Faker;

$factory->define(Document::class, function (Faker $faker) {
    return [
        'width' => null,
        'height' => null,
        'nb_orig' => null,
        'quantity' => 1,
        'finish' => 'roulé',
        'delivery_id' => function () {
            return factory(Delivery::class)->create()->id;
        },
        'article_id' => null,
    ];
});

$factory->state(Document::class, 'with-article', function () {
    return [
        'article_id' => function () {
            return factory(Article::class)->create()->id;
        }
    ];
});
