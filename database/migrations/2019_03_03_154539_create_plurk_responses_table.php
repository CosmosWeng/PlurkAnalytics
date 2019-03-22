<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlurkResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('plurk_responses', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('plurk_id');
        //     $table->integer('user_id');
        //     $table->integer('response_id');
        //     $table->string('qualifier');
        //     $table->text('content')->nullable();
        //     $table->timestamp('posted');
        //     $table->unique(['plurk_id', 'response_id']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plurk_responses');
    }
}
