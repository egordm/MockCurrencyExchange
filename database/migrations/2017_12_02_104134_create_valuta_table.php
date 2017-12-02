<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateValutaTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Schema::create('valuta', function (Blueprint $table) {
			$table->increments('id');
			$table->string('symbol', 4);
			$table->string('name', 255);
			$table->unsignedTinyInteger('decimal_places');
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
		\Schema::dropIfExists('valuta');
	}
}
