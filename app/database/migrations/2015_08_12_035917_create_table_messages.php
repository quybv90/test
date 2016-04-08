<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMessages extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('messages', function($table)
     {
        $table->increments('id');
        $table->integer('from_id');
        $table->text('content');
        $table->string('title');
        $table->string('slug');
        $table->string('stage');
        $table->integer('to_id');
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
    Schema::drop('messages');
  }
}
