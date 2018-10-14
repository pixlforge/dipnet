<?php

use App\Ticker;
use Illuminate\Database\Seeder;

class TickersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ticker::class)->states('active')->create([
            'body' => "Oh, I've been so worried about you ever since you ran off the other night. Are you okay? You're a slacker. You wanna be a slacker for the rest of your life? this has gotta be a dream."
        ]);
    }
}
