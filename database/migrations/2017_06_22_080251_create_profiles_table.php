<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();

            $table->unsignedInteger('user_id')->default('0')->comment('用户编号');
            //$table->foreign('user_id')->references('users')->on('id')->onDelete('cascade');

            $table->string('nickname',20)->default('')->comment('昵称');
            $table->string('realname',20)->default('')->comment('真名');
            $table->string('avatar',255)->default('')->comment('头像');
            $table->text('introduce')->nullable()->comment('简介');
            $table->boolean('gender')->default(0)->comment('性别');
            $table->date('birth')->nullable()->comment('出生日期');

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
        Schema::dropIfExists('profiles');
    }
}
