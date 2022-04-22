<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
        Schema::create('slot_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booked_slot_id')->nullable();
            $table->string('by')->default('Doctor');
            $table->string('remark')->nullable();       
            $table->timestamps();

            $table->foreign('booked_slot_id')->references('id')->on('user_booked_slots');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slot_histories');
    }
}
