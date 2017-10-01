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
            'password' => bcrypt('secret'),
            'role' => 'administrateur',
            'email' => 'celien@pixlforge.ch',
            'email_confirmed' => 1
        ]);

        factory('App\User')->create([
            'username' => 'Célien',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'c-boillat@hotmail.com',
            'email_confirmed' => 1
        ]);

        factory('App\User')->create([
            'username' => 'Radu',
            'password' => bcrypt('secret'),
            'role' => 'administrateur',
            'email' => 'radu@bebold.ch',
            'email_confirmed' => 1
        ]);
    }
}
