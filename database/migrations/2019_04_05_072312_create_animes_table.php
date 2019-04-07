<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serie_code')->comment('系列作羅馬拼音 or 英文名代號');

            $table->integer('year')->comment('年代, ex:199x');
            $table->string('type')->nullable()->comment('類型, ex:spring, summer,..., movie, ova, oad');
            $table->string('aired_text')->comment('播放期間');
            //
            $table->timestamp('aired_start')->nullable()->comment('播放開始時間');
            $table->timestamp('aired_end')->nullable()->comment('播放結束時間');
            $table->integer('episode')->nullable()->comment('集數');
            $table->text('comment')->nullable()->comment('備註');

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
        Schema::dropIfExists('animes');
    }
}
