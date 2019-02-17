<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleAuthorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_author', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('article_id')->index();
            $table->unsignedInteger('author_id')->index();
            $table->boolean("display")->index();
            $table->timestamps();

            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('author_id')->references('id')->on('authors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_author');
    }
}
