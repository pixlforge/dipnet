<?php

use App\Ticker;
use Illuminate\Database\Seeder;

class TickersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ticker::class, 10)->create();
        factory(Ticker::class)->states('active')->create([
            'body' => 'Bienvenue sur la plateforme en développement Dipnet!'
        ]);
    }
}
