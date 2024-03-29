<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('session_id');
            $table->string('slot_name');
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_booked')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->foreign('session_id')->references('id')->on('sessions'); 
            $table->foreign('doctor_id')->references('id')->on('doctors'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_slots');
    }
}
