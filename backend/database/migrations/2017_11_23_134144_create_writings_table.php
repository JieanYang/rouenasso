<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWritingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('writings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title_writing')->nullable(false);
            $table->string('user_writing')->nullable(false);
            $table->timestamp('published_writing')->nullable()->index();
            $table->string('introduction_writing')->nullable(false);
            $table->string('image_writing')->nullable();
            $table->longText('html_writing')->nullable(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('writings');
    }
}
