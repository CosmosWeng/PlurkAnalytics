<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlurkUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plurk_users', function (Blueprint $table) {
            $table->integer('uuid')->unique()->comment('*噗浪編號');

            $table->integer('user_id')->nullable();
            $table->string('nick_name')->comment('*噗浪帳號');
            $table->string('display_name')->comment('*顯示名稱');

            $table->string('privacy')->default('world')->comment('隱私設定');
            $table->string('token')->nullable()->comment('Token');
            $table->string('secret')->nullable()->comment('Secret');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'uuid']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plurk_users');
    }
}
