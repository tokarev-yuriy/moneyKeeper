<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates plans table
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->float('value');
			$table->integer('category_id');
			$table->text('comment')->nullable();
			$table->timestamps();
            
            
            $table->index('user_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plans');
	}

}
