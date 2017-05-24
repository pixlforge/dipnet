<?php

use Illuminate\Database\Seeder;

class BusinessCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\BusinessComment::class, 10)->create();
    }
}
