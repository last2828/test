<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('deposits', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->integer('wallet_id')->unsigned();
        $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        $table->decimal('invested')->default('0');
        $table->decimal('percent')->default('0');
        $table->smallInteger('active')->default('0');
        $table->smallInteger('duration')->default('0');
        $table->smallInteger('accrue_times')->default('0');
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
//      Schema::dropIfExists('deposits');

      Schema::table('deposits', function (Blueprint $table) {
        $table->dropForeign('deposits_user_id_foreign');
        $table->dropForeign('deposits_wallet_id_foreign');
        $table->dropIfExists();
      });
    }
}
