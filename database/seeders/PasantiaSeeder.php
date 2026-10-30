<?php

namespace Database\Seeders;

use App\Models\Pasantia;
use Illuminate\Database\Seeder;

class PasantiaSeeder extends Seeder
{
    /**
     * Una pasantía REAL (Magneto365, consultada el 29/10/2026) y tres de EJEMPLO.
     *
     * - Se puede correr varias veces sin duplicar nada.
     * - Las de ejemplo llevan el aviso "Vacante de ejemplo" en el contacto y se borran juntas con:
     *   Pasantia::where('contacto', 'like', 'Vacante de ejemplo%')->delete();
     */
    public function run(): void
    {
        // ---------- REAL ----------
        Pasantia::updateOrCreate(
            ['url_postulacion' => 'https://www.magneto365.com/co/empleos/aprendiz-de-ingenieria-de-sistemas-soporte-y-redes-bogota-1116308'],
            [
                'titulo' => 'Aprendiz de Ingeniería de Sistemas (soporte y redes)',
                'empresa' => 'AEROSAN',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => null,
                'estipendio' => '$1.750.000',
                'fecha_inicio' => null,
                'descripcion' => 'Práctica con contrato de aprendizaje: soporte técnico de primer nivel a usuarios, apoyo en redes, mantenimiento de equipos e infraestructura tecnológica y documentación de procedimientos. Publicada en Magneto365 el 27/10/2026.',
                'requisitos' => [
                    'Estudiante activo de pregrado en Ingeniería de Sistemas',
                    'Aval de la institución educativa para el contrato de aprendizaje',
                    'Disponibilidad para prácticas presenciales en Bogotá',
                    'Conocimientos básicos de ofimática, soporte técnico y redes',
                ],
                'beneficios' => [
                    'Participación en proyectos reales de tecnología',
                    'Aprendizaje continuo',
                ],
                'contacto' => null,
                'fecha_cierre' => null,
            ]
        );

        // ---------- EJEMPLOS ----------
        $aviso = 'Vacante de ejemplo (no es una oferta real)';

        $ejemplos = [
            [
                'titulo' => 'Pasantía en marketing digital',
                'empresa' => 'Agencia Ejemplo',
                'ubicacion' => 'Remoto',
                'tipo' => 'Pasantía',
                'modalidad' => 'Remoto',
                'duracion_meses' => 5,
                'horario' => '20 horas semanales',
                'estipendio' => 'A convenir',
                'descripcion' => 'Apoyo en campañas y contenidos para redes sociales de pequeños negocios locales, con acompañamiento semanal.',
                'requisitos' => ['Estudiante de comunicación, mercadeo o afines', 'Conocimientos básicos de redes sociales', 'Creatividad'],
                'beneficios' => ['Certificado', 'Mentorías'],
            ],
            [
                'titulo' => 'Trainee comercial',
                'empresa' => 'Almacén Ejemplo',
                'ubicacion' => 'Montería',
                'tipo' => 'Trainee',
                'modalidad' => 'Presencial',
                'duracion_meses' => 6,
                'horario' => 'Tiempo completo',
                'estipendio' => 'A convenir',
                'descripcion' => 'Formación en ventas y atención al cliente con rotación por distintas áreas del almacén.',
                'requisitos' => ['Bachiller completo', 'Orientación al cliente', 'Buena presentación'],
                'beneficios' => ['Capacitación continua', 'Posibilidad de contratación'],
            ],
            [
                'titulo' => 'Pasantía administrativa',
                'empresa' => 'Oficina Ejemplo',
                'ubicacion' => 'Montería',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => 4,
                'horario' => '25 horas semanales',
                'estipendio' => 'A convenir',
                'descripcion' => 'Apoyo en archivo, atención de llamadas y organización de documentos de la oficina.',
                'requisitos' => ['Estudiante de administración o afines', 'Manejo básico de Excel', 'Buena comunicación'],
                'beneficios' => ['Certificado', 'Experiencia práctica'],
            ],
        ];

        foreach ($ejemplos as $ejemplo) {
            Pasantia::updateOrCreate(
                ['titulo' => $ejemplo['titulo'], 'empresa' => $ejemplo['empresa']],
                $ejemplo + [
                    'contacto' => $aviso,
                    'url_postulacion' => null,
                    'fecha_inicio' => now()->addDays(30)->toDateString(),
                    'fecha_cierre' => now()->addDays(25)->toDateString(),
                ]
            );
        }
    }
}
