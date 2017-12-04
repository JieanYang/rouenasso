<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->string('title')->nullable(false);
            $table->integer('category')->nullable(false);
            $table->string('preview_img_url')->nullable();
            $table->string('preview_text')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
