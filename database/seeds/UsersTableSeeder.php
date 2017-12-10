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
            'username' => 'John Doe',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'johndoe@example.com',
            'email_confirmed' => 1,
            'company_id' => 1,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Jane Doe',
            'password' => bcrypt('secret'),
            'role' => 'utilisateur',
            'email' => 'janedoe@example.com',
            'email_confirmed' => 1,
            'company_id' => 1,
            'confirmation_token' => null
        ]);
    }
}
