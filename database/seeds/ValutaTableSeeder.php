<?php

use Illuminate\Database\Seeder;

class ValutaTableSeeder extends Seeder
{
	const DEFAULT_VALUTAE = [
		[
			'symbol' => 'BTC',
			'name' => 'Bitcoin',
			'decimal_places' => 8
		],
		[
			'symbol' => 'EUR',
			'name' => 'Euro',
			'decimal_places' => 2
		],
		[
			'symbol' => 'USD',
			'name' => 'US Dollar',
			'decimal_places' => 2
		]
	];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws Exception|Throwable
	 */
    public function run()
    {
	    DB::transaction(function () {
		    DB::table('valuta')->delete();
		    foreach (ValutaTableSeeder::DEFAULT_VALUTAE as $data) {
			    \App\Models\Valuta::create($data)->save();
		    }
	    });
    }
}
