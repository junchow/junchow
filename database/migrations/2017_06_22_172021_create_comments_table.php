<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');

            $table->text('content')->comment('内容');

            $table->unsignedInteger('user_id')->default('0')->comment('评论人');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('question_id')->nullable()->comment('问题');
            $table->foreign('question_id')->references('id')->on('questions');

            $table->unsignedInteger('answer_id')->nullable()->comment('回答');
            $table->foreign('answer_id')->references('id')->on('answers');

            $table->unsignedInteger('reply_id')->nullable()->comment('回复评论');
            $table->foreign('reply_id')->references('id')->on('comments');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
