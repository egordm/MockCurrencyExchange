<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_symbols', function (Blueprint $table) {
            $table->unsignedInteger('valuta_pair_id');
            $table->string('symbol', 8);
            $table->unsignedTinyInteger('type');

            $table->primary(['valuta_pair_id', 'symbol', 'type']);
            $table->index(['valuta_pair_id', 'symbol', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_symbols');
    }
}
