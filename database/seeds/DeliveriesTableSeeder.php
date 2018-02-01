<?php

use Dipnet\Delivery;
use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Delivery::class, 10)->create();
    }
}
