<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');

            $table->text('content')->nullable()->comment('内容');

            $table->unsignedInteger('user_id')->default('0')->comment('答题人');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('question_id')->default('0')->comment('问题');
            $table->foreign('question_id')->references('id')->on('questions');

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
        Schema::dropIfExists('answers');
    }
}
