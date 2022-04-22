<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_orders', function (Blueprint $table) {
            $table->id();
            $table->string('orderId')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('transaction_id')->nullable();
            $table->enum('source',['online','wallet','partial wallet','coupon with wallet','coupon with wallet and online','coupon']);
            $table->string('coupon_code')->nullable();
            $table->float('coupon_price', 7, 2)->default(0);
            $table->float('wallet_deduct', 7, 2)->default(0);
            $table->float('online_paid', 7, 2)->default(0);
            $table->float('total_price', 7, 2);
            $table->enum('type',['slot','product','rent','ambulence','bed']);
            $table->enum('status',['completed','pending','failed']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_orders');
    }
}
