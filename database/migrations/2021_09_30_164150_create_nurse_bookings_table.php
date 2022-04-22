<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNurseBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurse_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('user_name');
            $table->string('user_mobile');
            $table->string('nurse_type');
            $table->string('location');
            $table->enum('status',[0,1,2,3,4,5])->default(0);
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
        Schema::dropIfExists('nurse_bookings');
    }
}
