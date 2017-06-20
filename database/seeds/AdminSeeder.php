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
            'email_validated' => 1
        ]);

        factory('App\User')->create([
            'username' => 'Célien',
            'password' => bcrypt('erfgbn'),
            'role' => 'utilisateur',
            'email' => 'c-boillat@hotmail.com',
            'email_validated' => 1
        ]);

        factory('App\User')->create([
            'username' => 'Radu',
            'password' => bcrypt('password'),
            'role' => 'administrateur',
            'email' => 'radu@bebold.ch',
            'email_validated' => 1
        ]);
    }
}
