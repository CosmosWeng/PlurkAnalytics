<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeEpisodeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_episode_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anime_episode_id')->comment('Anime Episode ID');
            $table->string('title')->comment('標題');
            $table->text('synopsis')->nullable()->comment('大綱');

            $table->timestamp('updated_at')->useCurrent()->comment('*更新時間');
            $table->timestamp('created_at')->useCurrent()->comment('*建立時間');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anime_episode_infos');
    }
}
