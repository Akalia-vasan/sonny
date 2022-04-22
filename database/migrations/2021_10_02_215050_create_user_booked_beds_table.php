<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBookedBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_booked_beds', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('bed_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->float('price', 7, 2);
            $table->string('remark')->nullable();
            $table->enum('booking_status',['Pending','Confirm','Declined'])->default('Pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); 
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
        Schema::dropIfExists('user_booked_beds');
    }
}
