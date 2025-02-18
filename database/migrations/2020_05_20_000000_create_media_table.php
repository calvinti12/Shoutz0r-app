<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'media',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('filename');
                $table->char('hash', 128);
                $table->boolean('is_video');
                $table->smallInteger('duration')->unsigned();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
