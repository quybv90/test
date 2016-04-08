<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountViewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
    Schema::create('count_views', function($table)
       {
          $table->increments('id');
          $table->integer('post_id')->unique();
          $table->integer('total_view'); // "photo"   "video"  "music" ...
          $table->timestamps();
       });
		//
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
    Schema::drop('count_views');
		//
	}

}
