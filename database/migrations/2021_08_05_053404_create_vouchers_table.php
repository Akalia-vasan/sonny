<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 40)->unique();
            $table->date('valid_from')->nullable();
            $table->date('valid_to')->nullable();
            $table->enum('discount_type',['fixed','percentage'])->default('fixed');
            $table->decimal('value', 10,2)->default(0.00)->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('used')->default(0);
            $table->mediumText('description')->nullable();
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
        Schema::dropIfExists('vouchers');
    }
}
