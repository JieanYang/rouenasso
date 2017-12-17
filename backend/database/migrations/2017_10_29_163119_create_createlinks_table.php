<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreatelinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('createlinks', function (Blueprint $table) {
            // 此处设置主键为link删除了id,每次在User模型中find($link)来确定是否可以注册.
            $table->bigInteger('user_id');
            $table->string('link')->unique()->index();
            $table->timestamps();
            $table->datetime('expires');
            $table->primary(['link']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('createlinks');
    }
}
