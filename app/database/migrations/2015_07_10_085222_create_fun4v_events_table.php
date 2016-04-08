<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFun4vEventsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fun4v_events', function($table)
           {
              $table->increments('id');
              $table->integer('user_id');
              $table->text('content');
              $table->string('title');
              $table->integer('status');
              $table->datetime('started_date');
              $table->datetime('end_date');
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
		Schema::drop('fun4v_events');
	}

}
