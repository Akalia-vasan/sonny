<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->string('day');
            $table->enum('time_frame',['20','30','45','60'])->comment('in minutes');
            $table->string('session_name');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('status')->default(0);
            $table->timestamps();
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
        Schema::dropIfExists('sessions');
    }
}
