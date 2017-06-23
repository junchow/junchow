<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_user', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id')->default('0')->comment('用户');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('answer_id')->default('0')->comment('回答');
            $table->foreign('answer_id')->references('id')->on('answers');

            $table->unsignedTinyInteger('vote')->default('0')->comment('投票:0踩1赞');

            $table->unique(['user_id','answer_id','vote']);//一个用户只能对一个问题投一次票（顶或踩）

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
        Schema::dropIfExists('answer_user');
    }
}
