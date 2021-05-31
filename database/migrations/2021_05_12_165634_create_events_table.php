<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('author_id');
            $table->string('type');
            $table->unsignedInteger('max_partecipants')->nullable();
            $table->decimal('price')->nullable();
            $table->string('ticket_office', 2083)->nullable();
            $table->string('website', 2083)->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->dateTime('starting_time')->nullable(); //TODO - Per testing ora è nullable
            $table->dateTime('ending_time')->nullable();
            $table->timestamps();
        });

        //registrazioni all'evento
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('event_id');
        });
        //tag dell'evento
        Schema::create('event_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id');
            $table->foreignId('tag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('event_tag');
    }
}
