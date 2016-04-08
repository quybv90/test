<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('type')->default(1);
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password');
            $table->text('remember_token')->nullable();
            $table->text('avatar_url')->nullable();
            $table->integer('point')->default(0);
            $table->integer('post_number')->default(0);
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
		Schema::drop('users');
		//
	}

}
