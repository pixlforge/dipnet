<?php

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
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Radu',
            'password' => bcrypt('bebold'),
            'role' => 'administrateur',
            'email' => 'radu@bebold.ch',
            'email_confirmed' => 1,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Aurore',
            'password' => bcrypt('bebold'),
            'role' => 'administrateur',
            'email' => 'aurore@bebold.ch',
            'email_confirmed' => 1,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Gilles',
            'password' => bcrypt('dipnet'),
            'role' => 'administrateur',
            'email' => 'gilles@dip.ch',
            'email_confirmed' => 1,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        factory(User::class)->create([
            'username' => 'Mathias',
            'password' => bcrypt('multicop'),
            'role' => 'administrateur',
            'email' => 'mathias@multicop.ch',
            'email_confirmed' => 1,
            'company_id' => null,
            'confirmation_token' => null
        ]);

        /**
         * Different admins are generated related to the app name.
         * Available app names are "Dipnet" or "Multicop".
         */
//        if (config('app.name') === 'Dipnet') {
//            factory(User::class)->create([
//                'username' => 'Gilles',
//                'password' => bcrypt('dipnet'),
//                'role' => 'administrateur',
//                'email' => 'gilles@dip.ch',
//                'email_confirmed' => 1,
//                'company_id' => null,
//                'confirmation_token' => null
//            ]);
//        } else if (config('app.name') === 'Multicop') {
//            factory(User::class)->create([
//                'username' => 'Mathias',
//                'password' => bcrypt('multicop'),
//                'role' => 'administrateur',
//                'email' => 'mathias@multicop.ch',
//                'email_confirmed' => 1,
//                'company_id' => null,
//                'confirmation_token' => null
//            ]);
//        }
    }
}
