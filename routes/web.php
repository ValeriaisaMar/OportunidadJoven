<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpleoController;
use App\Http\Controllers\Admin\EmpleoController as AdminEmpleoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/empleos', [EmpleoController::class, 'index'])->name('empleos');

Route::get('/pasantias', function () {
    return view('pasantias');
})->name('pasantias');

Route::get('/cursos', function () {
    return view('cursos');
})->name('cursos');

Route::get('/foro', function () {
    return view('foro');
})->name('foro');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

Route::patch('/profile/cv', [ProfileController::class, 'updateCv'])->name('profile.cv.update');
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('empleos', AdminEmpleoController::class)->except('show');
});

require __DIR__.'/auth.php';