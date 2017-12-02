<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintValutaPairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    \Schema::table('valuta_pairs', function (Blueprint $table) {
		    $table->foreign('valuta_primary_id')->references('id')->on('valuta')->onDelete('cascade');
		    $table->foreign('valuta_secondary_id')->references('id')->on('valuta')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    \Schema::table('valuta_pairs', function (Blueprint $table) {
		    $table->dropForeign('valuta_pairs_valuta_primary_id_foreign');
		    $table->dropForeign('valuta_pairs_valuta_secondary_id_foreign');
	    });
    }
}
