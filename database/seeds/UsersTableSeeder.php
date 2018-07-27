<?php

use App\User;
use App\Company;
use App\Contact;
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
            'email_confirmed' => true,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Radu',
            'password' => bcrypt('bebold'),
            'role' => 'administrateur',
            'email' => 'radu@bebold.ch',
            'email_confirmed' => true,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Gilles',
            'password' => bcrypt('dipnet'),
            'role' => 'administrateur',
            'email' => 'gilles@dip.ch',
            'email_confirmed' => true,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Mathias',
            'password' => bcrypt('multicop'),
            'role' => 'administrateur',
            'email' => 'mathias@multicop.ch',
            'email_confirmed' => true,
            'company_id' => null,
            'confirmation_token' => null
        ]);

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
