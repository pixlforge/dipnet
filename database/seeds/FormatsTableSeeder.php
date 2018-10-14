<?php

use App\Format;
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
        factory(Format::class)->create([
            'name' => 'A2',
            'height' => 594,
            'width' => 420,
        ]);

        factory(Format::class)->create([
            'name' => 'A3',
            'height' => 420,
            'width' => 297,
        ]);

        factory(Format::class)->create([
            'name' => 'A4',
            'height' => 297,
            'width' => 210,
        ]);

        factory(Format::class)->create([
            'name' => 'A5',
            'height' => 210,
            'width' => 148,
        ]);
    }
}
