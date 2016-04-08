<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('answer_rates', function($table)
           {
              $table->increments('id');
              $table->integer('user_id');
              $table->integer('answer_id');
              $table->integer('rate');
              $table->timestamps();
           });
	    	//
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('answer_rates');
		//
	}

}
