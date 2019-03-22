<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('*編號');
            $table->string('name')->comment('*顯示名稱');
            $table->string('email')->unique()->comment('*電子信箱');
            $table->string('password');
            $table->text('api_token')->nullable();
            $table->rememberToken();

            $table->timestamp('email_verified_at')->nullable()->comment('信箱驗證日期');
            $table->timestamp('updated_at')->useCurrent()->comment('*更新時間');
            $table->timestamp('created_at')->useCurrent()->comment('*建立時間');
            $table->softDeletes()->comment('刪除時間');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
