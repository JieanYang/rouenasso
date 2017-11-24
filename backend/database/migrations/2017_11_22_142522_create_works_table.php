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
            $table->string('title_work')->nullable(false);
            $table->string('company_work')->nullable(false);
            $table->string('city_work')->nullable(false);
            $table->unsignedInteger('salary_work')->nullable(false);
            $table->timestamp('published_work')->nullable()->index();
            $table->longText('html_work')->nullable(false);
            $table->bigInteger('view_work')->unsigned()->nullable(false);
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
