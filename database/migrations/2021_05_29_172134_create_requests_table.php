<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('nome');
            $table->string('cognome');
            $table->date('data_nascita');
            $table->string('codice_documento');
            $table->enum('tipo_documento', [
                'driving license',
                'identity card',
                'passport'
            ]);
            $table->boolean('accettazione')->default(false);
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
        Schema::dropIfExists('requests');
    }
}
