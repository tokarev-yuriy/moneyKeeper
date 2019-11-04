<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates wallet groups table
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CreateWalletsCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wallets_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->integer('sort')->nullable();
            $table->timestamps();
          });
          
        Schema::table('wallets', function(Blueprint $table) {
            $table->integer('group_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wallets_groups');
    }
}
