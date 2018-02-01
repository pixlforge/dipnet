<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArticlesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ContactsTableSeeder::class);
        $this->call(BusinessesTableSeeder::class);
        $this->call(FormatsTableSeeder::class);
    }
}
