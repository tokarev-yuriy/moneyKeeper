<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ImageWalletTable extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
          Schema::table('wallets', function(Blueprint $table)
          {
            $table->string('icon')->nullable();
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
        }

}
