<?php

use App\Models\Curso;
use App\Models\Empleo;
use App\Models\Pasantia;
use Database\Seeders\CursoSeeder;
use Database\Seeders\EmpleoSeeder;
use Database\Seeders\EmpleosRealesSeeder;
use Database\Seeders\PasantiaSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Borra las ofertas de ejemplo, carga las reales y muestra cuántas quedaron.
// Uso:  php artisan ofertas:cargar
Artisan::command('ofertas:cargar', function () {
    $this->call('db:seed', ['--class' => EmpleoSeeder::class, '--force' => true]);
    $this->call('db:seed', ['--class' => EmpleosRealesSeeder::class, '--force' => true]);
    $this->call('db:seed', ['--class' => PasantiaSeeder::class, '--force' => true]);
    $this->call('db:seed', ['--class' => CursoSeeder::class, '--force' => true]);

    $ejemplos = Empleo::where('contacto', 'like', '%ejemplo%')->orWhere('empresa', 'like', '%ejemplo%')->count()
        + Pasantia::where('contacto', 'like', '%ejemplo%')->orWhere('empresa', 'like', '%ejemplo%')->count()
        + Curso::where('contacto', 'like', '%ejemplo%')->orWhere('institucion', 'like', '%ejemplo%')->count();

    $this->newLine();
    $this->table(['Ofertas en la base de datos', 'Cantidad'], [
        ['Empleos', Empleo::count()],
        ['Pasantías', Pasantia::count()],
        ['Cursos', Curso::count()],
        ['De ejemplo (debe ser 0)', $ejemplos],
    ]);
})->purpose('Borra las ofertas de ejemplo y carga las ofertas reales');
