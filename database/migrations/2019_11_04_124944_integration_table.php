<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates integrations table
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class IntegrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('integrations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('type');
            $table->integer('wallet_id');
            $table->time('last_sync');
            $table->text('params');
            $table->text('category_rules')->nullable();
            $table->timestamps();
          });
          
        Schema::table('operations', function(Blueprint $table) {
            $table->string('ext_id')->nullable();
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
        Schema::drop('integrations');
    }
}
