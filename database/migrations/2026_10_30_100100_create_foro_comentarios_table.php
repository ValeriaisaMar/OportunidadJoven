<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Comentarios (respuestas) de cada publicación. */
    public function up(): void
    {
        Schema::create('foro_comentarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('foro_post_id')->constrained('foro_posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('contenido');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foro_comentarios');
    }
};
