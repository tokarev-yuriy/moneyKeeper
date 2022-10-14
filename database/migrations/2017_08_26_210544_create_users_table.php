<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates categories users
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users', function ($table) {
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('name');
			$table->string('password');
			$table->string('remember_token')->nullable();
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
		Schema::drop('users');
	}

}
