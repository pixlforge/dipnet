<?php

use Illuminate\Database\Seeder;

class DeliveryCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\DeliveryComment::class, 10)->create();
    }
}
