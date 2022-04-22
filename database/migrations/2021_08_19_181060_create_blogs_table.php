<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author')->nullable();
            $table->enum('type',['admin','doctor'])->default('admin');
            $table->unsignedBigInteger('category_id');
            $table->string('blog_title');
            $table->mediumText('blog_description');
            $table->string('blog_image');
            $table->string('video_url')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('blog_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
