<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandlestickNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candlestick_nodes', function (Blueprint $table) {
	        $table->unsignedDecimal('open', 14, 8);
	        $table->unsignedDecimal('high', 14, 8);
	        $table->unsignedDecimal('low', 14, 8);
	        $table->unsignedDecimal('close', 14, 8);
	        $table->unsignedDecimal('volume', 20, 8);
            $table->unsignedInteger('open_time');
            $table->unsignedInteger('close_time');
	        $table->unsignedTinyInteger('interval');
	        $table->unsignedInteger('valuta_pair_id');

	        $table->primary(['close_time', 'interval', 'valuta_pair_id']);
            $table->index(['close_time', 'interval', 'valuta_pair_id']);
        });

	    \Schema::table('candlestick_nodes', function (Blueprint $table) {
		    $table->foreign('valuta_pair_id')->references('id')->on('valuta_pairs')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    \Schema::table('candlestick_nodes', function (Blueprint $table) {
		    $table->dropForeign('candlestick_nodes_valuta_pair_id_foreign');
	    });
        Schema::dropIfExists('candlestick_nodes');
    }
}
