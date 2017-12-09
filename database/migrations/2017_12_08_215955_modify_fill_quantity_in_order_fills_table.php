<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyFillQuantityInOrderFillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_fills', function (Blueprint $table) {
	        $table->unsignedDecimal('quantity', 14, 8);
	        $table->dropColumn('percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_fills', function (Blueprint $table) {
	        $table->decimal('percentage', 5, 4);
	        $table->dropColumn('quantity');
        });
    }
}
