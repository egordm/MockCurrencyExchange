<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderFillsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		\Schema::create('order_fills', function (Blueprint $table) {
			$table->unsignedBigInteger('order_primary_id');
			$table->unsignedBigInteger('order_secondary_id');
			$table->decimal('percentage', 5, 4);
			$table->timestamps();

			$table->primary(['order_primary_id', 'order_secondary_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		\Schema::dropIfExists('order_fills');
	}
}
