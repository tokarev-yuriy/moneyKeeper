<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates operation table
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CreateOperationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('operations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->date('date');
			$table->smallInteger('year');
			$table->tinyInteger('month');
			$table->float('value');
			$table->integer('category_id');
			$table->text('comment')->nullable();
      $table->enum('type', array('income', 'spend', 'transfer'));
			$table->integer('wallet_from_id')->nullable();
			$table->integer('wallet_to_id')->nullable();
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
		Schema::drop('operations');
	}

}
