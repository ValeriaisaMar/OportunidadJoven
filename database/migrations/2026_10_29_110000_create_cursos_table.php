<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('institucion');
            $table->string('categoria')->nullable();
            $table->string('modalidad')->default('Online');
            $table->string('nivel')->default('Principiante');
            $table->string('duracion')->nullable();
            $table->string('horario')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->unsignedInteger('cupos')->nullable();
            $table->boolean('certificado')->default(false);
            $table->text('descripcion');
            $table->json('temas')->nullable();
            $table->string('url_inscripcion', 500)->nullable();
            $table->string('contacto')->nullable();
            $table->date('fecha_cierre')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
