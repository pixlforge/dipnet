<?php

use App\Article;
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
            'description' => 'NB - A4 - Papier',
            'type' => 'impression'
        ]);

        factory(Article::class)->create([
            'description' => 'Vernis UV',
            'type' => 'option'
        ]);

        factory(Article::class)->create([
            'description' => 'Reliure Wiro',
            'type' => 'option'
        ]);
    }
}
