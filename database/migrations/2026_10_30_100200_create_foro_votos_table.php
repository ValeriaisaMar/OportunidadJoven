<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Votos (me gusta / no me gusta) de publicaciones Y comentarios.
     * Una sola tabla sirve para los dos: "votable" guarda a qué pertenece el voto.
     * valor = 1 (me gusta) o -1 (no me gusta).
     */
    public function up(): void
    {
        Schema::create('foro_votos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->morphs('votable');              // votable_type + votable_id
            $table->tinyInteger('valor');
            $table->timestamps();

            // Cada persona solo puede tener un voto por publicación o comentario
            $table->unique(['user_id', 'votable_type', 'votable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foro_votos');
    }
};
