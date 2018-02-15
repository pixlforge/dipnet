<?php

use Dipnet\Format;
use Illuminate\Database\Seeder;

class FormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Format::class, 5)->create();
    }
}
