<?php

namespace Tests\Feature;

use App\Models\Curso;
use App\Models\Empleo;
use App\Models\Pasantia;
use App\Models\User;
use Database\Seeders\CursoSeeder;
use Database\Seeders\EmpleoSeeder;
use Database\Seeders\EmpleosRealesSeeder;
use Database\Seeders\PasantiaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Revisa que las páginas con el diseño nuevo carguen con las ofertas reales. */
class PaginasTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo('2026-10-30 10:00:00'); // las ofertas reales cierran en noviembre de 2026

        $this->seed([EmpleoSeeder::class, EmpleosRealesSeeder::class, PasantiaSeeder::class, CursoSeeder::class]);
    }

    public function test_solo_quedan_ofertas_reales(): void
    {
        $this->assertSame(0, Empleo::where('contacto', 'like', '%ejemplo%')->count());
        $this->assertSame(0, Pasantia::where('contacto', 'like', '%ejemplo%')->count());
        $this->assertSame(0, Curso::where('contacto', 'like', '%ejemplo%')->count());

        $this->assertSame(0, Empleo::whereNull('url_postulacion')->count());
        $this->assertSame(0, Pasantia::whereNull('url_postulacion')->count());
        $this->assertSame(0, Curso::whereNull('url_inscripcion')->count());
    }

    public function test_los_seeders_se_pueden_correr_dos_veces_sin_duplicar(): void
    {
        $antes = [Empleo::count(), Pasantia::count(), Curso::count()];

        $this->seed([EmpleosRealesSeeder::class, PasantiaSeeder::class, CursoSeeder::class]);

        $this->assertSame($antes, [Empleo::count(), Pasantia::count(), Curso::count()]);
    }

    public function test_las_paginas_publicas_cargan(): void
    {
        $this->get('/')->assertOk()->assertSee('Comienza tu carrera profesional hoy')->assertSee('Empleos destacados');
        $this->get('/empleos')->assertOk()->assertSee('Búsqueda de Empleos')
            ->assertViewHas('empleos', fn ($empleos) => $empleos->total() === Empleo::count());
        $this->get('/pasantias')->assertOk()->assertSee('Pasantías y Programas Trainee')->assertSee('Grupo Éxito');
        $this->get('/cursos')->assertOk()->assertSee('Cursos Gratuitos Disponibles')->assertSee('Cisco Networking Academy');
        $this->get('/cursos?vista=proximos')->assertOk()->assertSee('inscripción abierta');
        $this->get('/foro')->assertOk()->assertSee('Foro de la Comunidad');
    }

    public function test_filtro_de_modalidad_en_empleos(): void
    {
        $this->get('/empleos?modalidad[]=Híbrido')
            ->assertOk()
            ->assertViewHas('empleos', fn ($empleos) => $empleos->total() === Empleo::where('modalidad', 'Híbrido')->count()
                && $empleos->getCollection()->every(fn ($empleo) => $empleo->modalidad === 'Híbrido'))
            ->assertSee('mallas horarias');
    }

    public function test_perfil_muestra_los_cursos_guardados(): void
    {
        $user = User::factory()->create();
        $curso = Curso::where('institucion', 'freeCodeCamp')->firstOrFail();
        $user->cursosGuardados()->attach($curso);

        $this->actingAs($user)->get('/profile')
            ->assertOk()
            ->assertSee('Elementos Guardados')
            ->assertSee($curso->titulo);

        $this->actingAs($user)->get('/')->assertOk()->assertSee('Ir a mi panel');
        $this->actingAs($user)->get('/empleos')->assertOk()->assertSee('Aplicar ahora');
    }
}
