<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
  public function up()
  {
    Schema::create('posts', function($table)
       {
          $table->increments('id');
          $table->integer('user_id');
          $table->string('type'); // 1.normal  2. 18+
          $table->string('category'); // "photo"   "video"  "music" ...
          $table->string('title');
          $table->text('content');
          $table->text('description');
          $table->float('rate');
          $table->string('status');
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
    Schema::drop('posts');
    //
  }

}
