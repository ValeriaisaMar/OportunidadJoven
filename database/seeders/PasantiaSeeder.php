<?php

namespace Database\Seeders;

use App\Models\Pasantia;
use Illuminate\Database\Seeder;

class PasantiaSeeder extends Seeder
{
    /**
     * Pasantías y programas de aprendizaje REALES (Magneto365, Computrabajo y elempleo.com,
     * consultadas el 29-30/10/2026).
     *
     * - Se puede correr varias veces sin duplicar nada: se identifican por el enlace.
     * - Borra las pasantías de ejemplo que se habían creado antes.
     * - "Trainee" se usa para los programas que incluyen estudio + práctica con título.
     */
    public function run(): void
    {
        Pasantia::where('contacto', 'like', 'Vacante de ejemplo%')->delete();

        $pasantias = [
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
                'beneficios' => ['Participación en proyectos reales de tecnología', 'Aprendizaje continuo'],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/aprendiz-de-ingenieria-de-sistemas-soporte-y-redes-bogota-1116308',
                'fecha_cierre' => '2026-11-30',
            ],
            [
                'titulo' => 'Aprendiz SENA en Talento Humano',
                'empresa' => 'Zentria',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => null,
                'estipendio' => '$1.751.000 (apoyo de sostenimiento)',
                'fecha_inicio' => null,
                'descripcion' => 'Etapa productiva en centros de salud ambulatorios: apoyo a procesos de talento humano, tareas administrativas, organización documental y de archivo, y orientación a usuarios de consulta externa. Publicada en Magneto365 el 29/10/2026.',
                'requisitos' => [
                    'Técnico SENA en formación en Talento Humano, Auxiliar Administrativo o Auxiliar Administrativo en Salud',
                    'Disponibilidad para firmar contrato de aprendizaje',
                    'Manejo básico de herramientas ofimáticas',
                    'Competencias en gestión documental',
                ],
                'beneficios' => ['Contrato de aprendizaje', 'Experiencia en el sector salud'],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/aprendiz-sena-talento-humano-bogota-1119219',
                'fecha_cierre' => '2026-11-30',
            ],
            [
                'titulo' => 'Aprendiz SENA comercial (punto de venta)',
                'empresa' => 'Arturo Calle',
                'ubicacion' => 'Bucaramanga',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => 'Tiempo completo',
                'estipendio' => '$1.750.905 (apoyo de sostenimiento)',
                'fecha_inicio' => null,
                'descripcion' => 'Etapa productiva en tienda: servicio al cliente, asesoría comercial, activaciones, apoyo en inventarios y acompañamiento del proceso de ventas. Contrato de aprendizaje SENA. Publicada en Magneto365 el 27/10/2026.',
                'requisitos' => [
                    'Estudiante técnico o tecnólogo en Mercadeo y Ventas, Asesoría Comercial, Gestión de Mercados o afines',
                    'Estar habilitado para iniciar la etapa productiva',
                    'Disponibilidad para firmar contrato de aprendizaje SENA',
                ],
                'beneficios' => ['Contrato de aprendizaje SENA', 'Crecimiento profesional en la marca'],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/aprendiz-sena-bucaramanga-1116062',
                'fecha_cierre' => '2026-11-30',
            ],
            [
                'titulo' => 'Estudia gratis con el SENA patrocinado por Grupo Éxito',
                'empresa' => 'Grupo Éxito',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Trainee',
                'modalidad' => 'Presencial',
                'duracion_meses' => 12,
                'horario' => 'Etapa lectiva 6 meses + etapa productiva 6 meses',
                'estipendio' => '50% del SMLV (etapa lectiva) y 75% del SMLV (etapa productiva)',
                'fecha_inicio' => null,
                'descripcion' => 'Formación técnica gratuita en el SENA durante 6 meses y luego 6 meses de práctica en almacenes o centros de distribución de Grupo Éxito, con apoyo de sostenimiento en ambas etapas. Las clases empiezan en enero de 2027. Publicada en Magneto365 el 27/10/2026.',
                'requisitos' => [
                    'Ser mayor de edad o cumplir 18 años en los próximos 4 meses',
                    'Tener aprobado como mínimo 9.º grado',
                    'No haber tenido contrato de aprendizaje antes',
                    'No haber trabajado antes en Grupo Éxito',
                    'No estar estudiando actualmente en el SENA',
                ],
                'beneficios' => ['Título técnico SENA sin costo', 'Práctica en Grupo Éxito', 'Apoyo de sostenimiento'],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/estudia-gratis-con-el-sena-y-patrocinado-por-grupo-exito-1115013',
                'fecha_cierre' => '2026-11-30',
            ],
            [
                'titulo' => 'Patrocinio SENA – Técnico en Servicios Comerciales y Financieros',
                'empresa' => 'Banco de Occidente',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Trainee',
                'modalidad' => 'Presencial',
                'duracion_meses' => 15,
                'horario' => 'Lunes a viernes en horario de oficina y sábados hasta mediodía',
                'estipendio' => 'Apoyo de sostenimiento durante los 15 meses',
                'fecha_inicio' => null,
                'descripcion' => 'Programa de aprendices del banco: estudias el técnico en Servicios Comerciales y Financieros del SENA y aprendes en oficina el procesamiento de documentos y recaudos, el manejo de caja y la atención a clientes. Publicada en Magneto365 el 26/10/2026.',
                'requisitos' => [
                    'Bachiller graduado',
                    'Tener la prueba ICFES',
                    'Disponibilidad de tiempo completo',
                    'No haber cursado un técnico o tecnólogo en el SENA',
                    'No haber firmado contrato de aprendizaje antes',
                ],
                'beneficios' => ['Título técnico SENA', 'Contrato de aprendizaje por 15 meses'],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/patrocinio-sena-bogota-1114653',
                'fecha_cierre' => '2026-11-19',
            ],
            [
                'titulo' => 'Aprendiz SENA en el sector salud',
                'empresa' => 'Zentria – Clínica Chía',
                'ubicacion' => 'Chía (Cundinamarca)',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => '42 horas semanales',
                'estipendio' => 'Apoyo de sostenimiento',
                'fecha_inicio' => null,
                'descripcion' => 'Etapa práctica en clínicas del grupo. Hay cupos en Chía, Tunja, Facatativá, Sogamoso, Chocontá, Zipaquirá y Mosquera. No requiere experiencia. Publicada en Magneto365 el 26/10/2026.',
                'requisitos' => [
                    'Técnico o tecnólogo en enfermería, apoyo administrativo en salud, auxiliar de farmacia o talento humano',
                    'Estar en etapa práctica',
                    'No requiere experiencia',
                ],
                'beneficios' => ['Contrato de aprendizaje', 'Varias sedes en Cundinamarca y Boyacá'],
                'url_postulacion' => 'https://www.magneto365.com/co/empleos/aprendiz-sena-sector-salud-1113216',
                'fecha_cierre' => '2026-11-30',
            ],

            // ---------- Computrabajo (consultadas el 30/10/2026) ----------
            [
                'titulo' => 'Aprendiz SENA o practicante en SST',
                'empresa' => 'Colchones El Dorado S.A.',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => 'Tiempo completo',
                'estipendio' => '$1.750.905',
                'fecha_inicio' => null,
                'descripcion' => 'Práctica en seguridad y salud en el trabajo, en etapa lectiva o productiva: apoyo a los equipos en tareas del área, análisis de información, informes y organización de actividades internas. Publicada en Computrabajo el 29/10/2026.',
                'requisitos' => [
                    'Estudiante activo de técnico, tecnólogo o profesional',
                    'Disponibilidad para contrato de aprendizaje o práctica universitaria de tiempo completo',
                    'Buena comunicación verbal y escrita',
                ],
                'beneficios' => ['Experiencia en una empresa reconocida a nivel nacional', 'Aprendizaje con un equipo de profesionales'],
                'url_postulacion' => 'https://co.computrabajo.com/ofertas-de-trabajo/oferta-de-trabajo-de-aprendiz-sena-o-practicante-sst-etapa-lectiva-o-productiva-en-bogota-dc-BE8947F9886F657B61373E686DCF3405',
                'fecha_cierre' => '2026-12-28',
            ],
            [
                'titulo' => 'Técnico bilingüe patrocinado (estudia y recibe apoyo económico)',
                'empresa' => 'Concentrix',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Trainee',
                'modalidad' => 'Presencial',
                'duracion_meses' => 15,
                'horario' => '9 meses de formación + 6 meses de práctica',
                'estipendio' => '75% del SMLV en formación y 100% del SMLV en práctica',
                'fecha_inicio' => null,
                'descripcion' => 'Programa técnico en call center bilingüe totalmente patrocinado por la empresa. Durante la formación tienes EPS y ARL; durante la práctica, además prestaciones, auxilio de transporte y caja de compensación. Publicada en Computrabajo el 29/10/2026.',
                'requisitos' => [
                    'Tener mínimo 18 años y ser bachiller académico',
                    'Inglés A2 o superior',
                    'No haber tenido contrato de aprendizaje',
                    'No estar estudiando ni trabajando actualmente',
                ],
                'beneficios' => ['Título técnico sin costo', 'Apoyo económico durante todo el programa', 'EPS y ARL'],
                'url_postulacion' => 'https://co.computrabajo.com/ofertas-de-trabajo/oferta-de-trabajo-de-estudia-patrocinado-y-recibe-apoyo-economico-tecnico-bilingue-con-concentrix-en-bogota-dc-799D746DF369DA8261373E686DCF3405',
                'fecha_cierre' => '2026-12-28',
            ],
            [
                'titulo' => 'Practicante de comercio exterior',
                'empresa' => 'Coordinadora Mercantil S.A.',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => '7:00 a. m. a 5:00 p. m.',
                'estipendio' => 'Salario mínimo (contrato de aprendizaje)',
                'fecha_inicio' => null,
                'descripcion' => 'Apoyo en procesos de importación, exportación y operaciones aduaneras. Sede según la operación: km 1,5 vía Cota, Calle 13 o aeropuerto. Publicada en Computrabajo el 21/10/2026.',
                'requisitos' => [
                    'Estudiante habilitado para realizar su práctica empresarial',
                    'Organización, responsabilidad y buena comunicación',
                    'Ganas de aprender',
                ],
                'beneficios' => ['Almuerzo gratis', 'Ruta desde Portal 80 o Av. Primera de Mayo', 'Día de estudio si sigues estudiando'],
                'url_postulacion' => 'https://co.computrabajo.com/ofertas-de-trabajo/oferta-de-trabajo-de-practicante-comercio-exterior-en-bogota-dc-AD9E3724BEA0C6EE61373E686DCF3405',
                'fecha_cierre' => '2026-12-20',
            ],
            [
                'titulo' => 'Practicante de diseño gráfico (inicio dic. 2026 o ene. 2027)',
                'empresa' => 'Adecco Colombia (para multinacional)',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => null,
                'estipendio' => '$1.749.900',
                'fecha_inicio' => null,
                'descripcion' => 'Práctica profesional en el área de marketing de una multinacional cerca al Portal Dorado: creación de piezas gráficas para campañas comerciales y eventos. Inicia en diciembre de 2026 o enero de 2027. Publicada en Computrabajo el 05/10/2026.',
                'requisitos' => [
                    'Estudiante de últimos semestres de Diseño Gráfico',
                    'Manejo de Canva y Adobe Illustrator',
                    'Disponibilidad para iniciar en diciembre o enero',
                ],
                'beneficios' => ['Proyectos de alto impacto', 'Trabajo directo con el área de Marketing'],
                'url_postulacion' => 'https://co.computrabajo.com/ofertas-de-trabajo/oferta-de-trabajo-de-practicante-diseno-grafico-diciembre-2026-o-enero-2027-en-bogota-dc-E82650416E96F83261373E686DCF3405',
                'fecha_cierre' => '2026-12-04',
            ],
            [
                'titulo' => 'Practicante universitario en gestión humana',
                'empresa' => 'Grupo BIOS',
                'ubicacion' => 'Mosquera (Cundinamarca)',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => null,
                'estipendio' => '$1.750.905',
                'fecha_inicio' => null,
                'descripcion' => 'Práctica en Gestión Humana: apoyo en selección y contratación, bienestar y clima organizacional y otros procesos del área. Publicada en Computrabajo el 29/10/2026.',
                'requisitos' => [
                    'Estudiante universitario de Psicología, Administración de Empresas o afines',
                    'Disponibilidad para práctica presencial en Mosquera',
                ],
                'beneficios' => ['Aprendizaje en varios procesos de gestión humana', 'Empresa diversa e incluyente'],
                'url_postulacion' => 'https://co.computrabajo.com/ofertas-de-trabajo/oferta-de-trabajo-de-practicante-universitario-psicologia-administracion-de-empresas-o-afines-en-mosquera-31C807954D2FE07D61373E686DCF3405',
                'fecha_cierre' => '2026-12-28',
            ],

            // ---------- elempleo.com (consultadas el 30/10/2026) ----------
            [
                'titulo' => 'Practicante o aprendiz en gestión documental',
                'empresa' => 'Empresa confidencial (vía elempleo)',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Presencial',
                'duracion_meses' => null,
                'horario' => 'Lunes a viernes de 7:00 a. m. a 4:30 p. m.',
                'estipendio' => '100% del salario mínimo',
                'fecha_inicio' => null,
                'descripcion' => 'Prácticas productivas en gestión documental mediante contrato de aprendizaje. Publicada en elempleo el 29/10/2026.',
                'requisitos' => [
                    'Estudiante técnico, tecnólogo o profesional en Gestión Documental',
                    'Aval de la institución para el contrato de aprendizaje',
                ],
                'beneficios' => ['Contrato de aprendizaje'],
                'url_postulacion' => 'https://www.elempleo.com/co/ofertas-trabajo/practicante-o-aprendiz-en-gestion-documental-1886787067',
                'fecha_cierre' => '2026-12-28',
            ],
            [
                'titulo' => 'Practicante universitario de Ingeniería de Sistemas (2027-1)',
                'empresa' => 'MINISO',
                'ubicacion' => 'Bogotá',
                'tipo' => 'Pasantía',
                'modalidad' => 'Híbrido',
                'duracion_meses' => null,
                'horario' => 'Lunes a viernes',
                'estipendio' => 'Salario mínimo + EPS + ARL',
                'fecha_inicio' => null,
                'descripcion' => 'Vacantes de práctica universitaria para el primer semestre de 2027 con contrato de aprendizaje. Según el área, se puede trabajar de forma híbrida. Publicada en elempleo el 29/10/2026.',
                'requisitos' => [
                    'Estudiante de Ingeniería de Sistemas habilitado para práctica en 2027-1',
                ],
                'beneficios' => ['Día de cumpleaños libre', 'Convenios (Smart, Open English, Juan Valdez, entre otros)'],
                'url_postulacion' => 'https://www.elempleo.com/co/ofertas-trabajo/practicante-universitario-202701-ing-de-sistemas-1886786923',
                'fecha_cierre' => '2026-12-28',
            ],
        ];

        foreach ($pasantias as $pasantia) {
            Pasantia::updateOrCreate(
                ['url_postulacion' => $pasantia['url_postulacion']],
                $pasantia + ['contacto' => null]
            );
        }
    }
}
