<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->index()->nullable(false);
            $table->string('title_movement')->nullable(false);
            $table->string('introduction_movement')->nullable(false);
            $table->string('image_movement')->nullable();
            $table->longText('html_movement')->nullable(false);
            $table->bigInteger('view_movement')->unsigned()->nullable(false);
            $table->timestamp('published_movement')->nullable()->index();
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
        Schema::dropIfExists('movements');
    }
}
