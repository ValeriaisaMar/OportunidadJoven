<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Pasantia extends Model
{
    public const TIPOS = ['Pasantía', 'Trainee'];

    protected $table = 'pasantias';

    protected $fillable = [
        'titulo', 'empresa', 'ubicacion', 'tipo', 'modalidad',
        'duracion_meses', 'horario', 'estipendio', 'fecha_inicio',
        'descripcion', 'requisitos', 'beneficios',
        'url_postulacion', 'contacto', 'fecha_cierre',
    ];

    protected $casts = [
        'requisitos' => 'array',
        'beneficios' => 'array',
        'fecha_inicio' => 'date',
        'fecha_cierre' => 'date',
    ];

    /** Foto de la tarjeta (una de las fotos del diseño). */
    public function getFotoUrlAttribute(): string
    {
        return asset('images/ofertas/oferta-' . (($this->id % 3) + 1) . '.jpg');
    }

    /** Solo las que no han vencido (o no tienen fecha de cierre). */
    public function scopeVigentes(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('fecha_cierre')->orWhereDate('fecha_cierre', '>=', today());
        });
    }
}
