<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title',128)->default('')->comment('标题');
            $table->text('description')->nullable()->comment('描述');

            $table->unsignedInteger('user_id')->default('0')->comment('评论人');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedInteger('admin_id')->default('0')->comment('审核人');

            $table->unsignedInteger('status')->default('0')->comment('审核状态');

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
        Schema::dropIfExists('questions');
    }
}
