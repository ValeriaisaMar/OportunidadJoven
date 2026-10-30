<?php

namespace Database\Seeders;

use App\Models\Empleo;
use Illuminate\Database\Seeder;

class EmpleosRealesSeeder extends Seeder
{
    /**
     * Vacantes reales tomadas de Magneto365 (consultadas el 29/10/2026).
     * Cada una apunta a su oferta original, que es donde se hace la postulación.
     *
     * Se puede correr varias veces sin duplicar vacantes: se identifican por el enlace.
     * Magneto no muestra fecha de cierre, así que quedan sin vencimiento: hay que revisarlas.
     */
    public function run(): void
    {
        $empleos = [
            [
                'titulo' => 'Consultor comercial senior (seguros e inversiones)',
                'empresa' => 'MetLife Colombia (publica Juan Fernando Mendoza)',
                'ubicacion' => 'Medellín',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => '1 a 2 años',
                'salario' => '$2.500.000 a $7.000.000 (según resultados)',
                'descripcion' => 'Asesoría a clientes en seguros y soluciones de inversión: prospección, seguimiento de cartera, propuestas y cierre de ventas. Contrato indefinido con ingresos variables por comisiones. Publicada en Magneto365 el 29/10/2026.',
                'requisitos' => [
                    '2 años de experiencia',
                    'Formación desde tecnólogo en administración, finanzas, economía o afines',
                    'Experiencia en ventas y asesoría',
                    'Manejo básico de ofimática y CRM',
                    'Red de contactos activa («mercado natural»)',
                ],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/consultor-comercial-senior-seguros-e-inversiones-medellin-1118435',
            ],
            [
                'titulo' => 'Operador/a de sistemas N1 (Control-M)',
                'empresa' => 'Indra',
                'ubicacion' => 'Bogotá',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => '1 a 2 años',
                'salario' => 'A convenir',
                'descripcion' => 'Operación y monitoreo de plataformas tecnológicas con Control-M: seguimiento de procesos automatizados, gestión de alertas e incidentes de primer nivel. Turnos rotativos en operación 7x24; el lugar de trabajo depende del proyecto. Contrato indefinido. Publicada en Magneto365 el 15/10/2026.',
                'requisitos' => [
                    'Técnico, tecnólogo o profesional en sistemas, informática, telecomunicaciones o afines',
                    'Experiencia de 1 año en operación o soporte TI (deseable)',
                    'Manejo operativo de Control-M',
                    'Conocimientos básicos de Windows/SCCM y comandos Unix',
                    'Disponibilidad para turnos rotativos 7x24',
                ],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/ingenieros-de-sistemas-expertos-en-control-m-1100281',
            ],
            [
                'titulo' => 'Auxiliar logístico (inventarios)',
                'empresa' => 'Human Servicess SAS',
                'ubicacion' => 'La Calera (Bogotá)',
                'modalidad' => 'Presencial',
                'jornada' => 'Tiempo completo',
                'experiencia' => 'Hasta 1 año',
                'salario' => '$2.600.000 a $3.200.000',
                'descripcion' => 'Recepción, almacenamiento, despacho y control de inventarios de mercancía para el sector gastronómico, incluido el cargue y descargue. Contrato por obra o labor. Publicada en Magneto365 el 29/10/2026.',
                'requisitos' => [
                    'Técnico o tecnólogo',
                    'Mínimo 12 meses de experiencia en logística o inventarios',
                    'Conocimientos en despacho y control de inventarios',
                    'Registro de facturas',
                ],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/auxiliar-logistico-inventarios-1118427',
            ],
        ];

        foreach ($empleos as $empleo) {
            Empleo::updateOrCreate(
                ['url_postulacion' => $empleo['url_postulacion']],
                $empleo + ['contacto' => null, 'fecha_cierre' => null]
            );
        }
    }
}
