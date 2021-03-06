<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlurkBotPlurkMissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plurk_bot_plurk_mission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plurk_id')->unique();
            $table->string('nick_name');
            $table->integer('mission_id');
            $table->integer('status')->default(1);
            // $table->jsonb('response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plurk_bot_plurk_mission');
    }
}
