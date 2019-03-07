<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCliplistClipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliplist_clips', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cliplist_id');
            $table->string('movie_id', 128)->comment('動画ID');
            $table->smallinteger('start_sec')->default(0)->comment('開始秒');
            $table->smallinteger('end_sec')->default(0)->comment('終了秒');
            $table->smallinteger('order')->comment('並び順');
            $table->string('comment', 128)->nullable()->comment('コメント');
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
        Schema::dropIfExists('cliplist_clips');
    }
}
