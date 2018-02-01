<?php

use Dipnet\User;
use Dipnet\Company;
use Dipnet\Contact;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
            },
            'confirmation_token' => null
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
            },
            'confirmation_token' => null
        ]);

        $johndoe = factory(User::class)->create([
            'username' => 'John Doe',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'johndoe@example.com',
            'email_confirmed' => 1,
            'company_id' => function () {
                return factory(Company::class)->create([
                    'name' => 'John Doe\'s company'
                ])->id;
            }
        ]);

        factory(Contact::class)->create([
            'user_id' => $johndoe->id,
            'company_id' => $johndoe->company->id
        ]);

        $janedoe = factory(User::class)->create([
            'username' => 'Jane Doe',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'janedoe@example.com',
            'email_confirmed' => 1,
            'company_id' => null,
            'is_solo' => true
        ]);

        factory(Contact::class)->create([
            'user_id' => $janedoe->id,
            'company_id' => $janedoe->company->id
        ]);
    }
}
