<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimeInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('anime_id')->comment('Anime ID');
            $table->integer('lang_id')->comment('語系 ID');
            $table->string('title')->comment('作品名稱');
            //
            $table->text('synopsis')->nullable()->comment('作品大綱');
            $table->string('producers')->nullable()->comment('製作公司');
            $table->string('director')->nullable()->comment('監督');
            $table->string('author')->nullable()->comment('作者');

            $table->string('wiki_source')->nullable()->comment('Wiki 網址');

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
        Schema::dropIfExists('anime_infos');
    }
}
