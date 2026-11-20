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

    /** Foto de la tarjeta: la que se cargó en el admin o una de las fotos del diseño. */
    public function getFotoUrlAttribute(): string
    {
        return $this->imagen ?: asset('images/ofertas/oferta-' . (($this->id % 3) + 1) . '.jpg');
    }
}
