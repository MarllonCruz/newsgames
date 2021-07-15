<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('master');
        });
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle');
            $table->string('category');
            $table->string('cover');
            $table->string('slug');
            $table->integer('status');
            $table->integer('created_user');
            $table->integer('update_user');
            $table->datetime('created_at');
            $table->text('body');
        });
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('slider_key');
            $table->integer('id_post');
        });
        Schema::create('highlights', function (Blueprint $table) {
            $table->id();
            $table->integer('id_post');
            $table->string('position');
        });
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->datetime('date_access');
            $table->string('page');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_tables');
    }
}
