<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 *  This Migration creates import profiles table
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class CreateImportTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
                //
          Schema::create('import_profile', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('encoding');
            $table->integer('start_row');
            $table->integer('control_row');
            $table->string('control_string');
            $table->integer('date_col');
            $table->integer('summ_col');
            $table->integer('category_col');
            $table->integer('desc_col')->nullable();
            $table->text('category_rules')->nullable();
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
        Schema::drop('import_profile');
        }

}
