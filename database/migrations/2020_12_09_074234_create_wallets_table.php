<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('wallets', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->decimal('balance')->default('0');
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
//      Schema::dropIfExists('wallets');

      Schema::table('wallets', function (Blueprint $table) {
        $table->dropForeign('wallets_user_id_foreign');
        $table->dropIfExists();
      });
    }
}
