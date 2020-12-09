<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->string('type', 30);
        $table->integer('user_id')->unsigned();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->integer('wallet_id')->unsigned();
        $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        $table->integer('deposit_id')->unsigned()->nullable();
        $table->foreign('deposit_id')->references('id')->on('deposits')->onDelete('cascade');
        $table->decimal('amount')->default('0');
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
//      Schema::dropIfExists('transactions');

      Schema::table('transactions', function (Blueprint $table) {
        $table->dropForeign('transactions_user_id_foreign');
        $table->dropForeign('transactions_wallet_id_foreign');
        $table->dropForeign('transactions_deposit_id_foreign');
        $table->dropIfExists();
      });
    }
}
