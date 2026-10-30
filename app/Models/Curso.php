<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Curso extends Model
{
    public const MODALIDADES = ['Online', 'Presencial', 'Híbrido'];
    public const NIVELES = ['Principiante', 'Intermedio', 'Avanzado'];

    protected $table = 'cursos';

    protected $fillable = [
        'titulo', 'institucion', 'categoria', 'modalidad', 'nivel',
        'duracion', 'horario', 'fecha_inicio', 'cupos', 'certificado',
        'descripcion', 'temas', 'url_inscripcion', 'contacto', 'fecha_cierre',
    ];

    protected $casts = [
        'temas' => 'array',
        'fecha_inicio' => 'date',
        'fecha_cierre' => 'date',
        'certificado' => 'boolean',
        'cupos' => 'integer',
    ];

    /** Solo los que no han vencido (o no tienen fecha de cierre). */
    public function scopeVigentes(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->whereNull('fecha_cierre')->orWhereDate('fecha_cierre', '>=', today());
        });
    }

    /** Usuarios que guardaron este curso. */
    public function guardadoPor(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'curso_user')->withTimestamps();
    }
}
