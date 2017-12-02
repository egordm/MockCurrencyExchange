<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('balances', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('user_id');
	        $table->unsignedInteger('valuta_id');
	        $table->unsignedDecimal('quantity', 16, 8);
            $table->timestamps();
        });

	    \Schema::table('balances', function (Blueprint $table) {
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		    $table->foreign('valuta_id')->references('id')->on('valuta')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    \Schema::table('balances', function (Blueprint $table) {
		    $table->dropForeign('balances_user_id_foreign');
		    $table->dropForeign('balances_valuta_id_foreign');
	    });

        \Schema::dropIfExists('balances');
    }
}
