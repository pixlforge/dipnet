<?php

use Dipnet\Business;
use Illuminate\Database\Seeder;

class BusinessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Business::class)->create([
            'name' => 'Fête du Slip',
            'description' => 'La fameuse Fête du Slip de Delémont',
            'company_id' => 1,
            'contact_id' => 1,
            'created_by_username' => 'Célien'
        ]);

        factory(Business::class)->create([
            'name' => 'Fête du Chihuahua',
            'description' => 'Rien à voir avec DJ Bobo',
            'company_id' => 1,
            'contact_id' => 2,
            'created_by_username' => 'Célien'
        ]);

        factory(Business::class)->create([
            'name' => 'Fête des Vendanges',
            'description' => 'Le rendez-vous des saoûlards',
            'company_id' => 2,
            'contact_id' => 3,
            'created_by_username' => 'Radu'
        ]);

        factory(Business::class)->create([
            'name' => 'Foire du Valais',
            'description' => 'Un autre rendez-vous pour saoûlards',
            'company_id' => 2,
            'contact_id' => 4,
            'created_by_username' => 'Radu'
        ]);
    }
}
