<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveMessagesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaveMessages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_leaveMessage')->nullable(false);
            $table->string('phone_leaveMessage')->nullable(false);
            $table->string('email_leaveMessage')->nullable(false);
            $table->boolean('agreeContact_leaveMessage')->nullable(false);
            $table->string('contactWay_leaveMessage')->nullable();
            $table->longText('message_leaveMessage')->nullable(false);
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
        Schema::dropIfExists('leaveMessages');
    }
}
