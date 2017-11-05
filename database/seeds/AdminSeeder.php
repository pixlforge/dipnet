<?php

use App\Company;
use App\User;
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
        factory(User::class)->create([
            'username' => 'Célien',
            'password' => bcrypt('secret'),
            'role' => 'administrateur',
            'email' => 'celien@pixlforge.ch',
            'email_confirmed' => 1,
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => 'Pixlforge',
                    'status' => 'permanent',
                    'description' => 'Agence de développement web',
                    'created_by_username' => 'Célien'
                ])->id;
            }
        ]);

        factory(User::class)->create([
            'username' => 'Radu',
            'password' => bcrypt('secret'),
            'role' => 'administrateur',
            'email' => 'radu@bebold.ch',
            'email_confirmed' => 1,
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => 'Bebold',
                    'status' => 'permanent',
                    'description' => 'Agence de développement Web',
                    'created_by_username' => 'Radu'
                ])->id;
            }
        ]);
    }
}
