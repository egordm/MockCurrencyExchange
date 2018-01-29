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
	    $this->call(ValutaTableSeeder::class);
	    $this->call(BalancesTableSeeder::class);
	    $this->call(ValutaPairsSeeder::class);
	    $this->call(BotSeeder::class);
    }
}
