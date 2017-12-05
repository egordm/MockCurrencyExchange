<?php

use Illuminate\Database\Seeder;

class BalancesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws Exception|Throwable
	 */
    public function run()
    {
	    DB::transaction(function () {
		    DB::table('balances')->delete();

		    $users = \App\User::all(['id']);
		    $valutae = \App\Models\Valuta::all('id');
		    foreach ($users as $user) {
				foreach ($valutae as $valuta) {
					if(random_int(0,1)) continue;

					\App\Models\Balance::create([
						'user_id' => $user->id,
						'valuta_id' => $valuta->id,
						'quantity' => random_int(0, 100000) / 400
					])->save();
				}
		    }
	    });
    }
}
