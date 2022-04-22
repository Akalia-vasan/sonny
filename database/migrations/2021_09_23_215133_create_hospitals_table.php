<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('hospital_name');
            $table->string('type');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('hospital_number');
            $table->string('hospital_email');
            $table->string('hospital_address');
            $table->string('google_address');
            $table->string('contact_person');
            $table->string('person_designation');
            $table->string('person_number');
            $table->mediumText('about');
            $table->string('rating')->default('0');
            $table->mediumText('images');
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
        Schema::dropIfExists('hospitals');
    }
}
