<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasantias', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('empresa');
            $table->string('ubicacion');
            $table->string('tipo')->default('Pasantía');
            $table->string('modalidad')->default('Presencial');
            $table->unsignedTinyInteger('duracion_meses')->nullable();
            $table->string('horario')->nullable();
            $table->string('estipendio')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->text('descripcion');
            $table->json('requisitos')->nullable();
            $table->json('beneficios')->nullable();
            $table->string('url_postulacion', 500)->nullable();
            $table->string('contacto')->nullable();
            $table->date('fecha_cierre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasantias');
    }
};
