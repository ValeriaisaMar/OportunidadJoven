<?php

use Database\Seeders\CursoSeeder;
use Database\Seeders\EmpleoSeeder;
use Database\Seeders\EmpleosRealesSeeder;
use Database\Seeders\PasantiaSeeder;
use Illuminate\Database\Migrations\Migration;

/**
 * Carga las ofertas reales y borra las de ejemplo con solo correr:  php artisan migrate
 * (así no hace falta acordarse de los db:seed). Los seeders se pueden volver a correr sin duplicar nada.
 */
return new class extends Migration
{
    public function up(): void
    {
        (new EmpleoSeeder)->run();          // borra empleos, pasantías y cursos de ejemplo
        (new EmpleosRealesSeeder)->run();
        (new PasantiaSeeder)->run();
        (new CursoSeeder)->run();
    }

    public function down(): void
    {
        // No se borran ofertas al revertir: son datos reales que la página puede seguir usando.
    }
};
