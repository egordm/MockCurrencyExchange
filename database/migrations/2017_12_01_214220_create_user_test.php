<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('users')->insert([
        	'name' => 'Vladimir Putin',
	        'email' => 'gopnik@adidas.ru',
	        'password' => Hash::make('no_nsa')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    DB::table('users')->where('email', '=', 'gopnik@adidas.ru')->delete();
    }
}
