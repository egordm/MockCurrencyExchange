<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValutaPairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Schema::create('valuta_pairs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('valuta_primary_id');
            $table->unsignedInteger('valuta_secondary_id');
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
        \Schema::dropIfExists('valuta_pairs');
    }
}
