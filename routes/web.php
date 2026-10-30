<?php

use App\Http\Controllers\Admin\CursoController as AdminCursoController;
use App\Http\Controllers\Admin\EmpleoController as AdminEmpleoController;
use App\Http\Controllers\Admin\PasantiaController as AdminPasantiaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EmpleoController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\PasantiaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/empleos', [EmpleoController::class, 'index'])->name('empleos');

Route::get('/pasantias', [PasantiaController::class, 'index'])->name('pasantias');

Route::get('/cursos', [CursoController::class, 'index'])->name('cursos');

// Foro: cualquiera puede leer; para publicar, comentar y votar hay que iniciar sesión
Route::get('/foro', [ForoController::class, 'index'])->name('foro');
Route::get('/foro/{post}', [ForoController::class, 'show'])->whereNumber('post')->name('foro.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::patch('/profile/cv', [ProfileController::class, 'updateCv'])
        ->name('profile.cv.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Guardar / quitar un curso de "Guardados"
    Route::post('/cursos/{curso}/guardar', [CursoController::class, 'guardar'])
        ->name('cursos.guardar');

    // Foro (con límite de envíos por minuto para evitar spam)
    Route::post('/foro', [ForoController::class, 'store'])
        ->middleware('throttle:10,1')->name('foro.store');
    Route::delete('/foro/{post}', [ForoController::class, 'destroy'])
        ->whereNumber('post')->name('foro.destroy');
    Route::post('/foro/{post}/comentarios', [ForoController::class, 'comentar'])
        ->whereNumber('post')->middleware('throttle:20,1')->name('foro.comentar');
    Route::delete('/foro/comentarios/{comentario}', [ForoController::class, 'destroyComentario'])
        ->whereNumber('comentario')->name('foro.comentarios.destroy');
    Route::post('/foro/votar/{tipo}/{id}', [ForoController::class, 'votar'])
        ->whereIn('tipo', ['post', 'comentario'])->whereNumber('id')
        ->middleware('throttle:60,1')->name('foro.votar');
});

// Panel de administración (solo correos en ADMIN_EMAILS)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('empleos', AdminEmpleoController::class)->except('show');

    Route::resource('pasantias', AdminPasantiaController::class)
        ->except('show')
        ->parameters(['pasantias' => 'pasantia']);

    Route::resource('cursos', AdminCursoController::class)->except('show');
});

require __DIR__ . '/auth.php';