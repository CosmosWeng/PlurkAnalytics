<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_episodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anime_id')->comment('Anime ID');
            $table->integer('season')->comment('季度 ex: 0,1,2');
            $table->integer('week')->nullable()->comment('每週首播放日');
            $table->decimal('episode', 8, 1)->nullable()->comment('集數, 顯示的集數, 有浮點數');

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
        Schema::dropIfExists('anime_episodes');
    }
}
