<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Un curso REAL (programa de cursos cortos del SENA) y cinco de EJEMPLO.
     *
     * - Se puede correr varias veces sin duplicar nada.
     * - Los de ejemplo llevan el aviso "Curso de ejemplo" en el contacto y se borran juntos con:
     *   Curso::where('contacto', 'like', 'Curso de ejemplo%')->delete();
     */
    public function run(): void
    {
        // ---------- REAL ----------
        Curso::updateOrCreate(
            ['url_inscripcion' => 'https://betowa.sena.edu.co'],
            [
                'titulo' => 'Cursos cortos complementarios del SENA',
                'institucion' => 'SENA',
                'categoria' => 'Varias áreas',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => 'Desde 40 horas (según el curso)',
                'horario' => null,
                'fecha_inicio' => null,
                'cupos' => null,
                'certificado' => true,
                'descripcion' => 'Oferta de cursos cortos y gratuitos del SENA en áreas como inglés, tecnología y administración. La inscripción se hace en la plataforma del SENA; las fechas y los cupos dependen de cada curso.',
                'temas' => ['Inglés', 'Tecnología', 'Administración'],
                'contacto' => null,
                'fecha_cierre' => null,
            ]
        );

        // ---------- EJEMPLOS ----------
        $aviso = 'Curso de ejemplo (no es una oferta real)';

        $ejemplos = [
            [
                'titulo' => 'Programación web para principiantes',
                'institucion' => 'Institución Ejemplo',
                'categoria' => 'Tecnología',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => '3 meses',
                'horario' => 'Lunes y miércoles 6:00-8:00 p. m.',
                'cupos' => 45,
                'descripcion' => 'Aprende HTML, CSS y JavaScript desde cero. Sin requisitos previos.',
                'temas' => ['HTML5', 'CSS3', 'JavaScript', 'Proyectos prácticos'],
                'dias' => 30,
            ],
            [
                'titulo' => 'Excel avanzado para oficinas',
                'institucion' => 'Instituto Ejemplo',
                'categoria' => 'Administración',
                'modalidad' => 'Presencial',
                'nivel' => 'Intermedio',
                'duracion' => '6 semanas',
                'horario' => 'Sábados 9:00-13:00',
                'cupos' => 30,
                'descripcion' => 'Domina Excel para el trabajo administrativo. Tablas dinámicas, macros y más.',
                'temas' => ['Fórmulas avanzadas', 'Tablas dinámicas', 'Macros', 'Visualización de datos'],
                'dias' => 20,
            ],
            [
                'titulo' => 'Marketing digital y redes sociales',
                'institucion' => 'Centro de Formación Ejemplo',
                'categoria' => 'Marketing',
                'modalidad' => 'Híbrido',
                'nivel' => 'Principiante',
                'duracion' => '2 meses',
                'horario' => 'Martes y jueves 7:00-9:00 p. m.',
                'cupos' => 25,
                'descripcion' => 'Aprende a gestionar redes sociales y crear campañas digitales efectivas.',
                'temas' => ['Instagram', 'Facebook Ads', 'Content Marketing', 'Analítica'],
                'dias' => 25,
            ],
            [
                'titulo' => 'Inglés básico para el trabajo',
                'institucion' => 'Academia de Idiomas Ejemplo',
                'categoria' => 'Idiomas',
                'modalidad' => 'Presencial',
                'nivel' => 'Principiante',
                'duracion' => '4 meses',
                'horario' => 'Lunes, miércoles y viernes 5:00-7:00 p. m.',
                'cupos' => 20,
                'descripcion' => 'Inglés enfocado en situaciones laborales y comunicación profesional.',
                'temas' => ['Vocabulario laboral', 'Conversación', 'Correos profesionales', 'Entrevistas'],
                'dias' => 15,
            ],
            [
                'titulo' => 'Atención al cliente y ventas',
                'institucion' => 'Entidad Ejemplo',
                'categoria' => 'Ventas',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => '5 semanas',
                'horario' => 'Jueves 6:00-8:00 p. m.',
                'cupos' => 40,
                'descripcion' => 'Técnicas de atención al cliente y estrategias de ventas efectivas.',
                'temas' => ['Comunicación efectiva', 'Manejo de objeciones', 'Cierre de ventas', 'Fidelización'],
                'dias' => 35,
            ],
        ];

        foreach ($ejemplos as $ejemplo) {
            $dias = $ejemplo['dias'];
            unset($ejemplo['dias']);

            Curso::updateOrCreate(
                ['titulo' => $ejemplo['titulo'], 'institucion' => $ejemplo['institucion']],
                $ejemplo + [
                    'certificado' => true,
                    'contacto' => $aviso,
                    'url_inscripcion' => null,
                    'fecha_inicio' => now()->addDays($dias)->toDateString(),
                    'fecha_cierre' => now()->addDays($dias - 5)->toDateString(),
                ]
            );
        }
    }
}
