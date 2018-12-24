<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_info', function (Blueprint $table) {
            $table->integer('user_id');
            $table->string('nick_name')->unique();
            $table->string('display_name')->nullable()->comment('顯示名稱');
            $table->decimal('karma')->nullable()->comment('Karma 值');
            $table->string('location')->nullable()->comment('地區');

            $table->text('about')->nullable()->comment('關於');
            $table->text('about_renderred')->nullable()->comment('關於, renderred');
            $table->string('avatar_big')->nullable()->comment('頭像');

            $table->index('user_id');
            $table->index('nick_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_info');
    }
}
