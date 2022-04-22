<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescription_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prescription_id');
            $table->string('medicine');
            $table->string('quantity');
            $table->string('days');
            $table->boolean('morning')->default(0);
            $table->boolean('afternoon')->default(0);
            $table->boolean('evening')->default(0);
            $table->boolean('night')->default(0);
            $table->timestamps();
            $table->foreign('prescription_id')->references('id')->on('prescriptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescription_details');
    }
}
