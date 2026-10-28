<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $fillable = [
        'titulo', 'empresa', 'ubicacion', 'modalidad', 'jornada',
        'experiencia', 'salario', 'descripcion', 'requisitos', 'imagen',
    ];

    protected $casts = [
        'requisitos' => 'array',
    ];
}
