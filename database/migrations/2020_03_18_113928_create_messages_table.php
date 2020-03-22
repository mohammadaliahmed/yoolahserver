<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('messageText')->nullable();
            $table->String('messageType');
            $table->String('imageUrl')->nullable();
            $table->String('audioUrl')->nullable();
            $table->String('videoUrl')->nullable();
            $table->String('documentUrl')->nullable();
            $table->String('filename')->nullable();
            $table->String('messageByPicUrl')->nullable();
            $table->String('messageByName');
            $table->integer('messageById');
            $table->integer('roomId');
            $table->bigInteger('time');
            $table->bigInteger('mediaTime')->nullable();
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
        Schema::dropIfExists('messages');
    }
}
