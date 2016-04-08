<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeechPhotosTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //
    Schema::create('leech_photos', function($table)
  {
    $table->increments('id');
    $table->integer('user_id');
    $table->string('title');
    $table->text('content');
    $table->text('description');
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
    //
    Schema::drop('leech_photos');
  }

}
