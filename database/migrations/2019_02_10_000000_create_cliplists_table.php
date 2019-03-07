<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCliplistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliplists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('channel_id');
            $table->string('title', 128)->comment('クリップリストタイトル');
            $table->string('password')->nullable()->comment('パスワード');
            $table->boolean('is_delete')->default(false)->comment('削除フラグ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliplists');
    }
}
