<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_feedback', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
	        $table->unsignedBigInteger('doctor_id');
            $table->integer('rating');
            $table->string('type');
            $table->text('feedback');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_feedback');
    }
}
