<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlurkApiLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plurk_api_logs', function (Blueprint $table) {
            $table->bigIncrements('id', true)->comment('ID');
            $table->timestamp('timestamp')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedInteger('code')->comment('狀態碼');

            $table->longText('params');
            $table->string('method', 16);
            $table->text('path');
            $table->integer('own_id')->comment('寫入者ID');
            $table->string('own_type', 16)->comment('寫入者類型');
            $table->longText('response');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plurk_api_logs');
    }
}
