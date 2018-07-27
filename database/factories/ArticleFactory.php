<?php

use App\Article;
use Faker\Generator as Faker;
use App\Http\Hashids\HashidsGenerator;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'reference' => HashidsGenerator::generateFor($faker->numberBetween(1, 999999999), 'articles'),
        'description' => $faker->word,
        'type' => $faker->randomElement(['impression', 'option']),
        'greyscale' => array_random([true, false])
    ];
});
