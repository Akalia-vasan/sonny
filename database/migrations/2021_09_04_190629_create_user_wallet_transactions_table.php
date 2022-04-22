<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->float('transaction_amount', 7, 2);
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('user_wallets')->onDelete('cascade'); 
            $table->foreign('order_id')->references('id')->on('user_orders'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_wallet_transactions');
    }
}
