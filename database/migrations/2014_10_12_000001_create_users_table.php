<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('lname')->nullable();
            $table->string('mobile')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('profile_image')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('send_password')->nullable();
            $table->boolean('active')->default(1);
            $table->string('fcm_token')->nullable();
            $table->date('dob')->nullable();
            $table->enum('gender',['Male','Female'])->nullable();
            $table->string('blood_group')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable(); 
            $table->string('country')->default('101');
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account')->nullable();
            $table->string('account_name')->nullable();
            $table->rememberToken();
            $table->timestamps();

           // $table->foreign('country')->references('id')->on('countries');
            // $table->foreign('state')->references('id')->on('states');
            // $table->foreign('city')->references('id')->on('cities');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
