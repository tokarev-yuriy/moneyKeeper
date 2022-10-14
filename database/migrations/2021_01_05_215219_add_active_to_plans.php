<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveToPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //alter table mkeep_plans modify created_at timestamp default '2011-01-01 00:00:00';
        //alter table mkeep_plans modify updates_at timestamp default '2011-01-01 00:00:00';
        
        Schema::table('plans', function (Blueprint $table) {
            $table->tinyInteger('active')->default(1);
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            //
        });
    }
}
