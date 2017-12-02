<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    \Schema::table('orders', function (Blueprint $table) {
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		    $table->foreign('valuta_pair_id')->references('id')->on('valuta_pairs')->onDelete('cascade');
	    });

	    \Schema::table('order_fills', function (Blueprint $table) {
		    $table->foreign('order_primary_id')->references('id')->on('orders')->onDelete('cascade');
		    $table->foreign('order_secondary_id')->references('id')->on('orders')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    \Schema::table('orders', function (Blueprint $table) {
	    	$table->dropForeign('orders_user_id_foreign');
	    	$table->dropForeign('orders_valuta_pair_id_foreign');
	    });

	    \Schema::table('order_fills', function (Blueprint $table) {
		    $table->dropForeign('order_fills_order_primary_id_foreign');
		    $table->dropForeign('order_fills_order_secondary_id_foreign');
	    });


	    // TODO:
    }
}
