<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Publicaciones del foro de la comunidad. */
    public function up(): void
    {
        Schema::create('foro_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('categoria');            // experiencias, preguntas, consejos, entrevistas
            $table->string('titulo');
            $table->text('contenido');
            $table->unsignedInteger('vistas')->default(0);
            $table->timestamps();

            $table->index('categoria');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foro_posts');
    }
};
