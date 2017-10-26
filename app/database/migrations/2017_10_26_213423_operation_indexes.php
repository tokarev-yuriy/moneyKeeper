<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates indexes for operations table
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class OperationIndexes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{       
        Schema::table('operations', function(Blueprint $table)
        {
            $table->index('user_id');
            $table->index(array('year', 'type'));
            $table->index(array('year', 'month', 'type'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('operations', function(Blueprint $table)
        {
            $table->dropIndex('user_id');
            $table->dropIndex(array('year', 'type'));
            $table->dropIndex(array('year', 'month', 'type'));
        });
	}

}
