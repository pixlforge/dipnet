<?php

use Dipnet\Contact;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Contact::class)->create([
            'name' => 'Borbet',
            'address_line1' => 'Le Borbet 23',
            'address_line2' => 'App 19',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '+41 (0)78 687 31 97',
            'email' => 'celien@pixlforge.ch',
            'user_id' => 1,
            'company_id' => 1,
        ]);

        factory(Contact::class)->create([
            'name' => 'Genévrier',
            'address_line1' => 'Le Genévrier 2',
            'address_line2' => 'App 2',
            'zip' => '2950',
            'city' => 'Courgenay',
            'phone_number' => '+41 (0)32 471 30 14',
            'email' => 'celien@pixlforge.ch',
            'user_id' => 1,
            'company_id' => 1,
        ]);

        factory(Contact::class)->create([
            'name' => 'Lausanne',
            'address_line1' => 'Le Flon',
            'zip' => '1003',
            'city' => 'Lausanne',
            'phone_number' => '+41 (0)78 123 45 67',
            'email' => 'radu@bebold.ch',
            'user_id' => 2,
            'company_id' => 2,
        ]);

        factory(Contact::class)->create([
            'name' => 'Martigny',
            'address_line1' => 'Avenue de la Poste',
            'zip' => '1920',
            'city' => 'Martigny',
            'phone_number' => '+41 (0)78 123 45 67',
            'email' => 'radu@bebold.ch',
            'user_id' => 2,
            'company_id' => 2,
        ]);
    }
}
