<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlurkBotMissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('plurk_bot_mission_logs', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('plurk_id');
        //     $table->string('mission_code');
        //     $table->timestamp('created_at')->useCurrent();

        //     $table->unique(['plurk_id', 'mission_code']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plurk_bot_mission_logs');
    }
}
