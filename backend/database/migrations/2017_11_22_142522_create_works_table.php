<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->index()->nullable(false);
            $table->string('job')->nullable(false);
            $table->string('company')->nullable(false);
            $table->string('city')->nullable(false);
            $table->unsignedInteger('salary')->nullable(false);
            $table->longText('html_content')->nullable(false);
            $table->timestamp('published_at')->nullable()->index();
            $table->bigInteger('view')->unsigned()->nullable(false);
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
        Schema::dropIfExists('works');
    }
}
