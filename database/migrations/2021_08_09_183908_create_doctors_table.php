<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('type')->nullable();
            $table->string('name');
            $table->string('l_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('email')->unique();
            $table->unsignedBigInteger('speciality_id');
            $table->string('mobile')->nullable()->unique();
            $table->string('profile_image')->nullable();
            $table->string('password');
            $table->float('price', 7, 2)->nullable();
            $table->string('send_password');
            $table->string('fcm_token')->nullable();
            $table->string('dob')->nullable();
            $table->mediumText('about')->nullable();
            $table->string('services',199);
            $table->string('specialisations',199);
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->string('pin_code')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('pinterest')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('youtube')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account')->nullable();
            $table->string('account_name')->nullable();
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities');
            $table->foreign('speciality_id')->references('id')->on('specialities');
            $table->foreign('area_id')->references('id')->on('areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
