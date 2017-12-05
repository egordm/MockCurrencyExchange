<?php

use Illuminate\Database\Seeder;

class ValutaPairsSeeder extends Seeder
{
	const ROOT_VALUTAE = ['USD'];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 * @throws Exception|Throwable
	 */
    public function run()
    {
	    DB::transaction(function () {
		    DB::table('valuta_pairs')->delete();

	    	$valutae = \App\Models\Valuta::all();
	    	foreach (ValutaPairsSeeder::ROOT_VALUTAE as $root_symbol) {
	    		$root_valuta = \App\Models\Valuta::where('symbol', '=', $root_symbol)->first();
	    		if(!$root_valuta) continue;
	    		foreach ($valutae as $valuta) {
	    			if($valuta->id == $root_valuta->id) continue;
	    			\App\Models\ValutaPair::create([
	    				'valuta_primary_id' => $root_valuta->id,
	    				'valuta_secondary_id' => $valuta->id,
				    ])->save();
			    }
		    }
	    });
    }
}
