<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('empleos', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('empresa');
        $table->string('ubicacion');
        $table->enum('modalidad', ['Presencial', 'Remoto', 'Híbrido'])->default('Presencial');
        $table->enum('jornada', ['Tiempo completo', 'Medio tiempo', 'Por proyecto'])->default('Tiempo completo');
        $table->string('experiencia')->default('Sin experiencia');
        $table->string('salario')->nullable();
        $table->text('descripcion');
        $table->json('requisitos')->nullable();
        $table->string('imagen')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleos');
    }
};
