<?php

use Illuminate\Database\Seeder;

class BotSeeder extends Seeder
{
	const BOT_COUNT = 30;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$current_count = count(\App\User::bots());
		for ($i = $current_count; $i < self::BOT_COUNT; $i++) {
			$user = new \App\User([
				'name' => 'Bot',
				'email' => str_random(40).'@bot.com',
				'role' => \App\User::ROLE_BOT
			]);
			$user->password = str_random(60);
			$user->save();
		}
	}
}
