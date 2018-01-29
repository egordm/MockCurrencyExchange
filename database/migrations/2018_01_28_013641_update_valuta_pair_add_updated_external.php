<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateValutaPairAddUpdatedExternal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('valuta_pairs', function (Blueprint $table) {
	        $table->dateTime('updated_external_at')->default(DB::raw('CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('valuta_pairs', function (Blueprint $table) {
	        $table->dropColumn('updated_external_at');
        });
    }
}
