<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlurksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plurks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plurk_id')->unique();
            $table->integer('user_id');
            $table->string('nick_name');
            $table->string('qualifier');

            $table->text('content')->nullable();
            $table->text('content_raw')->nullable();
            $table->timestamp('posted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plurks');
    }
}
