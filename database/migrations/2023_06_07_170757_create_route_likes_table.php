<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteLikesTable extends Migration
{
    public function up()
    {
        Schema::create('route_likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('route_id');
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('route_id')->references('id')->on('routes')->onDelete('cascade');

            // Definir una restricción única para evitar likes duplicados
            $table->unique(['user_id', 'route_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('route_likes');
    }
}

