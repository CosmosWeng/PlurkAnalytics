<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('timestamp')->default(0)->comment('時間戳');
            $table->string('code')->unique()->comment('*顯示名稱');
            $table->jsonb('json')->comment('*內容');
            $table->text('comment')->nullable()->comment('備註');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('caches');
    }
}
