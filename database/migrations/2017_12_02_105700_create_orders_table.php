<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
	        $table->unsignedInteger('valuta_pair_id');
	        $table->unsignedDecimal('price', 16, 8); // 00000000.00000000
	        $table->unsignedDecimal('fee', 14, 8)->default(0); // 000000.00000000
	        $table->unsignedDecimal('quantity', 14, 8); // 000000.00000000
	        $table->boolean('buy');
	        $table->unsignedTinyInteger('type');
	        $table->unsignedTinyInteger('status');
	        $table->boolean('settled');
	        $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Schema::dropIfExists('orders');
    }
}
