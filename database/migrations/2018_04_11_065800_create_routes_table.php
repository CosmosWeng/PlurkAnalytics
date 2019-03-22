<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->increments('id')->comment('系統流水號');
            $table->integer('parent_id')->default(0)->comment('Parent');
            $table->string('type', 16)->default('api')->comment('路由類型');
            $table->string('name')->unique()->comment('路由名稱');
            $table->string('method')->comment('請求類型,ex: GET|HEAD');
            $table->text('uri')->comment('路由對象');
            $table->text('redirect')->nullable()->comment('路由轉址');
            $table->jsonb('meta')->nullable()->comment('Meta');

            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('更新時間');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('建立時間');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('routes');
    }
}
