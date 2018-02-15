<?php

use Dipnet\Article;
use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class)->create([
            'description' => 'Paper',
            'type' => 'impression',
            'greyscale' => true
        ]);

        factory(Article::class)->create([
            'description' => 'Calque',
            'type' => 'impression',
            'greyscale' => true
        ]);

        factory(Article::class)->create([
            'description' => 'Film',
            'type' => 'impression',
            'greyscale' => true
        ]);

        factory(Article::class)->create([
            'description' => 'Plotter',
            'type' => 'impression',
            'greyscale' => true
        ]);

        factory(Article::class)->create([
            'description' => 'Paper',
            'type' => 'impression',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Calque',
            'type' => 'impression',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Film',
            'type' => 'impression',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Plotter',
            'type' => 'impression',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Vernis UV',
            'type' => 'option',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Reliure Wiro',
            'type' => 'option',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Vernis Lambda',
            'type' => 'option',
            'greyscale' => false
        ]);

        factory(Article::class)->create([
            'description' => 'Reliure Lambda',
            'type' => 'option',
            'greyscale' => false
        ]);
    }
}
