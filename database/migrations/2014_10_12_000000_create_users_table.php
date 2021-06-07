<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('type', ['normale', 'organizzatore', 'admin'])->default('normale');
            $table->string('name');
            $table->date('birthday')->nullable();
            $table->string('numero_telefono')->nullable();
            $table->text('sito_web')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('tag_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('tag_user');
    }
}
