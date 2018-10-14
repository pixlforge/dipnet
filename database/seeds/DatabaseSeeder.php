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
        $this->call(UsersTableSeeder::class);
        
        if (config('app.env') === 'local') {
            $this->call(ArticlesTableSeeder::class);
            $this->call(FormatsTableSeeder::class);
            $this->call(TickersTableSeeder::class);
        }
    }
}
