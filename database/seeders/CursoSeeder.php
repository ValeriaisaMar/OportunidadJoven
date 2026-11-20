<?php

namespace Database\Seeders;

use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    /**
     * Cursos gratuitos REALES con inscripción abierta todo el año (consultados el 29-30/10/2026).
     *
     * - Se puede correr varias veces sin duplicar nada: se identifican por el enlace.
     * - Borra los cursos de ejemplo que se habían creado antes.
     * - Son cursos a tu ritmo, por eso no tienen fecha de inicio ni cupos.
     */
    public function run(): void
    {
        Curso::where('contacto', 'like', 'Curso de ejemplo%')->delete();

        $cursos = [
            [
                'titulo' => 'Cursos cortos complementarios del SENA',
                'institucion' => 'SENA',
                'categoria' => 'Varias áreas',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => 'Desde 40 horas (según el curso)',
                'certificado' => true,
                'descripcion' => 'Oferta de cursos cortos y gratuitos del SENA en áreas como inglés, tecnología y administración. La inscripción se hace en la plataforma del SENA; las fechas y los cupos dependen de cada curso.',
                'temas' => ['Inglés', 'Tecnología', 'Administración'],
                'url_inscripcion' => 'https://betowa.sena.edu.co',
            ],
            [
                'titulo' => 'Inglés gratis con el SENA (English Does Work)',
                'institucion' => 'SENA',
                'categoria' => 'Idiomas',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => '13 niveles de 48 horas',
                'certificado' => true,
                'descripcion' => 'Programa virtual de inglés del SENA, con certificado por cada nivel. Abierto a colombianos mayores de 14 años, también si viven en el exterior. La inscripción se hace en Zajuna, sección Bilingüismo.',
                'temas' => ['Inglés básico', 'Inglés intermedio', 'Conversación', 'Comprensión de lectura'],
                'url_inscripcion' => 'https://zajuna.sena.edu.co',
            ],
            [
                'titulo' => 'Introducción a la ciberseguridad',
                'institucion' => 'Cisco Networking Academy',
                'categoria' => 'Tecnología',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => 'Unas 6 horas, a tu ritmo',
                'certificado' => true,
                'descripcion' => 'Curso gratuito en español para entender cómo proteger tu vida digital y la de una empresa. Al terminarlo recibes una insignia digital de Cisco. Es el primer curso de la ruta gratuita «Analista junior en ciberseguridad».',
                'temas' => ['Amenazas y ataques', 'Protección de datos y privacidad', 'Seguridad en las organizaciones', 'Carreras en ciberseguridad'],
                'url_inscripcion' => 'https://www.netacad.com/courses/introduction-to-cybersecurity',
            ],
            [
                'titulo' => 'Fundamentos de Python 1',
                'institucion' => 'Cisco Networking Academy y OpenEDG Python Institute',
                'categoria' => 'Tecnología',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => 'Unas 30 horas, a tu ritmo',
                'certificado' => true,
                'descripcion' => 'Curso gratuito para aprender a programar en Python desde cero, sin experiencia previa. Al terminarlo recibes una insignia digital y quedas preparado para la certificación PCEP.',
                'temas' => ['Variables y tipos de datos', 'Condicionales y bucles', 'Listas', 'Funciones'],
                'url_inscripcion' => 'https://www.netacad.com/courses/python-essentials-1',
            ],
            [
                'titulo' => 'Capacítate para el Empleo',
                'institucion' => 'Fundación Carlos Slim y Claro por Colombia',
                'categoria' => 'Varias áreas',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => 'Según el curso',
                'certificado' => true,
                'descripcion' => 'Plataforma con más de 300 cursos virtuales y gratuitos para aprender un oficio u ocupación, sin requisitos de estudios previos. Cada curso entrega una constancia al terminar.',
                'temas' => ['Administración', 'Tecnología', 'Servicio al cliente', 'Salud', 'Emprendimiento'],
                'url_inscripcion' => 'https://capacitateparaelempleo.org',
            ],
            [
                'titulo' => 'Certificación en Diseño Web Responsivo',
                'institucion' => 'freeCodeCamp',
                'categoria' => 'Tecnología',
                'modalidad' => 'Online',
                'nivel' => 'Principiante',
                'duracion' => 'Unas 300 horas, a tu ritmo',
                'certificado' => true,
                'descripcion' => 'Aprende HTML y CSS construyendo proyectos reales. Todo el contenido y la certificación son gratuitos y está disponible en español.',
                'temas' => ['HTML', 'CSS', 'Flexbox', 'CSS Grid', 'Diseño responsivo'],
                'url_inscripcion' => 'https://www.freecodecamp.org/espanol/learn/2022/responsive-web-design/',
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::updateOrCreate(
                ['url_inscripcion' => $curso['url_inscripcion']],
                $curso + [
                    'horario' => null,
                    'fecha_inicio' => null,
                    'cupos' => null,
                    'contacto' => null,
                    'fecha_cierre' => null,
                ]
            );
        }
    }
}
