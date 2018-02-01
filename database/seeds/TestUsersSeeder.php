<?php

use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
