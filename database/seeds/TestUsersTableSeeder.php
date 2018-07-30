<?php

use App\User;
use App\Company;
use App\Contact;
use Illuminate\Database\Seeder;

class TestUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $johndoe = factory(User::class)->create([
            'username' => 'John',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'john@example.com',
            'email_confirmed' => true,
            'company_id' => function () {
                return factory(Company::class)->create(['name' => "John Doe's company"])->id;
            },
            'is_solo' => false,
        ]);

        factory(Contact::class)->create([
            'user_id' => $johndoe->id,
            'company_id' => $johndoe->company->id
        ]);

        $janedoe = factory(User::class)->create([
            'username' => 'Jane',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'jane@example.com',
            'email_confirmed' => true,
            'company_id' => null,
            'is_solo' => true,
        ]);

        factory(Contact::class)->create([
            'user_id' => $janedoe->id,
            'company_id' => $janedoe->company->id
        ]);
    }
}
