<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Empleo;
use App\Models\Pasantia;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Seeder;

class EmpleoSeeder extends Seeder
{
    /**
     * Antes este seeder creaba vacantes de EJEMPLO. Ahora solo BORRA todas las ofertas de ejemplo
     * (empleos, pasantías y cursos) para que en la página queden solo ofertas reales.
     *
     * Se considera "de ejemplo" una oferta que:
     *  - dice "ejemplo" en el título, la empresa/institución o el contacto, o
     *  - es de una de las empresas inventadas de la plantilla de Figma, o
     *  - no tiene enlace ni contacto (o sea, nadie podría postularse).
     *
     * Las ofertas reales están en EmpleosRealesSeeder, PasantiaSeeder y CursoSeeder.
     */
    public const EMPRESAS_FICTICIAS = [
        'Tech Solutions SA', 'Retail Group', 'IT Services Corp', 'Hotel Plaza', 'Logística Express',
        'Digital Marketing Agency', 'Creativa Agency', 'HR Consulting Group', 'Design Studio',
        'Universidad Nacional', 'Universidad Nacional de Buenos Aires', 'Instituto Técnico Superior',
        'Centro de Formación Profesional', 'Instituto de Idiomas Municipal', 'Escuela de Arte y Diseño',
        'Cámara de Comercio',
    ];

    public function run(): void
    {
        $borrados = [
            'empleos' => $this->deEjemplo(Empleo::query(), 'empresa', 'url_postulacion')->delete(),
            'pasantías' => $this->deEjemplo(Pasantia::query(), 'empresa', 'url_postulacion')->delete(),
            'cursos' => $this->deEjemplo(Curso::query(), 'institucion', 'url_inscripcion')->delete(),
        ];

        $this->command?->info('Ofertas de ejemplo borradas: ' . collect($borrados)->map(fn ($n, $tipo) => "$n $tipo")->join(', '));
    }

    private function deEjemplo(Builder $query, string $columnaEmpresa, string $columnaEnlace): Builder
    {
        return $query->where(function (Builder $q) use ($columnaEmpresa, $columnaEnlace) {
            $q->where('titulo', 'like', '%ejemplo%')
              ->orWhere($columnaEmpresa, 'like', '%ejemplo%')
              ->orWhere('contacto', 'like', '%ejemplo%')
              ->orWhereIn($columnaEmpresa, self::EMPRESAS_FICTICIAS)
              ->orWhere(fn (Builder $sin) => $sin->whereNull($columnaEnlace)->whereNull('contacto'))
              ->orWhere(fn (Builder $sin) => $sin->where($columnaEnlace, '')->where(fn ($c) => $c->whereNull('contacto')->orWhere('contacto', '')));
        });
    }
}
