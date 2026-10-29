<?php

namespace Database\Seeders;

use App\Models\Empleo;
use Illuminate\Database\Seeder;

class EmpleoSeeder extends Seeder
{
    /**
     * Vacantes de EJEMPLO para que la página no se vea vacía mientras se cargan las reales.
     *
     * - Se pueden correr varias veces sin duplicarse.
     * - No borran nada de lo que ya exista.
     * - Todas llevan el mismo aviso en "contacto", y se eliminan juntas con:
     *   Empleo::where('contacto', 'like', 'Vacante de ejemplo%')->delete();
     */
    public function run(): void
    {
        $aviso = 'Vacante de ejemplo (no es una oferta real)';

        $empleos = [
            [
                'titulo' => 'Auxiliar administrativo',
                'empresa' => 'Oficina Ejemplo',
                'ubicacion' => 'Montería',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => 'Sin experiencia',
                'salario' => 'Salario mínimo + prestaciones',
                'descripcion' => 'Apoyo en archivo, atención telefónica y manejo de documentos. Se brinda inducción al cargo.',
                'requisitos' => ['Bachiller completo', 'Manejo básico de Word y Excel', 'Buena actitud de servicio'],
                'fecha_cierre' => now()->addDays(20)->toDateString(),
            ],
            [
                'titulo' => 'Vendedor/a de almacén',
                'empresa' => 'Almacén Ejemplo',
                'ubicacion' => 'Montería',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => 'Sin experiencia',
                'salario' => 'Salario mínimo + comisiones',
                'descripcion' => 'Atención a clientes en sala de ventas, organización de exhibidores y manejo de caja. Capacitación incluida.',
                'requisitos' => ['Mayor de 18 años', 'Ganas de aprender', 'Disponibilidad de horario'],
                'fecha_cierre' => now()->addDays(15)->toDateString(),
            ],
            [
                'titulo' => 'Recepcionista',
                'empresa' => 'Hotel Ejemplo',
                'ubicacion' => 'Montería',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => 'Hasta 1 año',
                'salario' => 'A convenir',
                'descripcion' => 'Recepción de huéspedes, reservas y atención de llamadas. Turnos rotativos.',
                'requisitos' => ['Buena presentación', 'Atención al cliente', 'Inglés básico (deseable)'],
                'fecha_cierre' => now()->addDays(25)->toDateString(),
            ],
            [
                'titulo' => 'Auxiliar de bodega',
                'empresa' => 'Distribuidora Ejemplo',
                'ubicacion' => 'Cereté',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => 'Sin experiencia',
                'salario' => 'Salario mínimo + prestaciones',
                'descripcion' => 'Recibo, alistamiento y despacho de mercancía. Se requiere buena condición física.',
                'requisitos' => ['Mayor de 18 años', 'Disponibilidad inmediata', 'Bachiller completo'],
                'fecha_cierre' => now()->addDays(10)->toDateString(),
            ],
            [
                'titulo' => 'Community manager junior',
                'empresa' => 'Agencia Ejemplo',
                'ubicacion' => 'Remoto',
                'modalidad' => 'Remoto',
                'jornada' => 'Medio tiempo',
                'experiencia' => 'Sin experiencia',
                'salario' => 'A convenir',
                'descripcion' => 'Creación de publicaciones y respuesta a mensajes en redes sociales de pequeños negocios locales.',
                'requisitos' => ['Manejo de redes sociales', 'Buena redacción', 'Creatividad'],
                'fecha_cierre' => null,
            ],
            [
                'titulo' => 'Soporte técnico junior',
                'empresa' => 'Tecnología Ejemplo',
                'ubicacion' => 'Montería',
                'modalidad' => 'Híbrido',
                'jornada' => 'Tiempo completo',
                'experiencia' => 'Hasta 1 año',
                'salario' => 'A convenir',
                'descripcion' => 'Atención de solicitudes de soporte de primer nivel, instalación de programas y mantenimiento básico de equipos.',
                'requisitos' => ['Conocimientos básicos de informática', 'Buena comunicación', 'Técnico o estudiante de sistemas'],
                'fecha_cierre' => now()->addDays(30)->toDateString(),
            ],
            [
                'titulo' => 'Auxiliar de cocina',
                'empresa' => 'Restaurante Ejemplo',
                'ubicacion' => 'Montería',
                'modalidad' => 'Presencial',
                'jornada' => 'Medio tiempo',
                'experiencia' => 'Sin experiencia',
                'salario' => 'Por horas',
                'descripcion' => 'Preparación de ingredientes, apoyo al cocinero y mantenimiento del orden y la limpieza de la cocina.',
                'requisitos' => ['Mayor de 18 años', 'Disponibilidad fines de semana', 'Responsabilidad'],
                'fecha_cierre' => now()->addDays(12)->toDateString(),
            ],
            [
                'titulo' => 'Tutor/a de refuerzo escolar',
                'empresa' => 'Academia Ejemplo',
                'ubicacion' => 'Lorica',
                'modalidad' => 'Presencial',
                'jornada' => 'Por proyecto',
                'experiencia' => 'Hasta 1 año',
                'salario' => 'Por sesión',
                'descripcion' => 'Clases de refuerzo en matemáticas y lenguaje para estudiantes de primaria y bachillerato.',
                'requisitos' => ['Bachiller o estudiante universitario', 'Paciencia y buena explicación', 'Disponibilidad en las tardes'],
                'fecha_cierre' => now()->addDays(18)->toDateString(),
            ],
        ];

        foreach ($empleos as $empleo) {
            Empleo::updateOrCreate(
                ['titulo' => $empleo['titulo'], 'empresa' => $empleo['empresa']],
                $empleo + ['contacto' => $aviso, 'url_postulacion' => null]
            );
        }
    }
}