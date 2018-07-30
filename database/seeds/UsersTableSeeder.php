<?php

use App\User;
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
    }
}
