<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('title')->nullable();
            $table->foreignId('event_id');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\Storage::makeDirectory('/public/images/');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
        \Illuminate\Support\Facades\Storage::deleteDirectory('/public/images/');
    }
}
