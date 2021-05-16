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
            $table->string('host');
            $table->string('type'); //probabilmente questo campo si espanderà nell'entità Category
            $table->unsignedInteger('max_partecipants')->nullable();
            $table->decimal('price')->nullable();
            $table->string('ticket_office', 2083)->nullable();
            $table->string('website', 2083)->nullable();
            $table->text('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->dateTime('starting_time')->nullable();
            $table->dateTime('ending_time')->nullable();
            $table->timestamps();
        });

        Schema::create('event_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id');
            $table->foreignId('events_id');
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
        Schema::dropIfExists('events');
    }
}
