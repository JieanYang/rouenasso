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
            $table->bigInteger('user_id')->unsigned()->index()->nullable(false);
            $table->string('image')->nullable();
            $table->string('title')->nullable(false);
            $table->string('username')->nullable(false);
            $table->string('introduction')->nullable(false);
            $table->longText('html_content')->nullable(false);
            $table->bigInteger('view')->unsigned()->nullable(false);
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamp('expiry_at')->nullable()->index();
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
