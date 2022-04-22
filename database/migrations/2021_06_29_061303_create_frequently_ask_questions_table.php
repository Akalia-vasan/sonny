<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrequentlyAskQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequently_ask_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('question', 299)->unique();
            $table->text('answer');
            $table->unsignedBigInteger('category_id');
            $table->boolean('active')->default(1);
            $table->timestamps();
            
            $table->foreign('category_id')->references('id')->on('faq_categories');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frequently_ask_questions');
    }
}
