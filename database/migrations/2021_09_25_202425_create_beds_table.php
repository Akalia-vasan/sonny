<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bed_type_id');
            $table->unsignedBigInteger('hospital_id');
            $table->string('aval_bed');
            $table->float('total_price', 7, 2);
            $table->float('price', 7, 2);
            $table->timestamps();

            $table->foreign('bed_type_id')->references('id')->on('bed_types'); 
            $table->foreign('hospital_id')->references('id')->on('hospitals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beds');
    }
}
