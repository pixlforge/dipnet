<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\User')->create([
            'username' => 'Pixlforge',
            'password' => bcrypt('erfgbn'),
            'role' => 'administrateur',
            'email' => 'celien@pixlforge.ch',
            'confirmed' => 1
        ]);

        factory('App\User')->create([
            'username' => 'Célien',
            'password' => bcrypt('erfgbn'),
            'role' => 'utilisateur',
            'email' => 'c-boillat@hotmail.com',
            'confirmed' => 1
        ]);

        factory('App\User')->create([
            'username' => 'Radu',
            'password' => bcrypt('password'),
            'role' => 'administrateur',
            'email' => 'radu@bebold.ch',
            'confirmed' => 1
        ]);
    }
}
