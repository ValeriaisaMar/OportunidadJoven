<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleo extends Model
{
    protected $fillable = [
    'titulo', 'empresa', 'ubicacion', 'modalidad', 'jornada',
    'experiencia', 'salario', 'descripcion', 'requisitos', 'imagen',
    'url_postulacion', 'contacto', 'fecha_cierre',
];

protected $casts = [
    'requisitos' => 'array',
    'fecha_cierre' => 'date',
];
}
