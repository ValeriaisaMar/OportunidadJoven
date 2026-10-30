<?php

namespace Database\Seeders;

use App\Models\ForoComentario;
use App\Models\ForoPost;
use App\Models\ForoVoto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Conversaciones de ejemplo para que el foro no se vea vacío en la demostración.
 *
 *   php artisan db:seed --class=ForoSeeder
 *
 * Crea algunas personas de ejemplo (con correo @demo.oportunidadjoven.test y una
 * clave aleatoria, o sea que nadie puede iniciar sesión con ellas) y sus publicaciones.
 * Solo se ejecuta si el foro está vacío. Todo se puede borrar desde la página
 * del foro con una cuenta administradora.
 */
class ForoSeeder extends Seeder
{
    public function run(): void
    {
        if (ForoPost::exists()) {
            $this->command?->warn('El foro ya tiene publicaciones: no se agregó nada.');

            return;
        }

        $personas = collect([
            'Carlos Martínez', 'Laura Fernández', 'Roberto Díaz', 'Sofía Ramírez',
            'Andrea Silva', 'Martín González', 'Ana García', 'Miguel Torres',
        ])->mapWithKeys(fn ($nombre) => [
            $nombre => User::firstOrCreate(
                ['email' => Str::slug($nombre, '.') . '@demo.oportunidadjoven.test'],
                ['name' => $nombre, 'password' => Str::random(40)]
            ),
        ]);

        $conversaciones = [
            [
                'autor' => 'Carlos Martínez', 'categoria' => 'preguntas', 'hace' => 2, 'vistas' => 234,
                'titulo' => '¿Cómo me preparo para mi primera entrevista de trabajo?',
                'contenido' => "Tengo mi primera entrevista la próxima semana y estoy muy nervioso.\n\n¿Qué consejos me pueden dar? ¿Cómo practican ustedes las respuestas?",
                'comentarios' => [
                    ['Ana García', 'Lo más importante es ser tú mismo y mostrar entusiasmo. Investiga sobre la empresa y prepara dos o tres preguntas para hacerles al final.'],
                    ['Miguel Torres', 'A mí me sirvió practicar frente al espejo y contar mi historia en menos de un minuto.'],
                ],
            ],
            [
                'autor' => 'Laura Fernández', 'categoria' => 'experiencias', 'hace' => 5, 'vistas' => 156,
                'titulo' => 'Mi experiencia en mi primer día de trabajo como pasante',
                'contenido' => "Quiero compartir cómo fue mi primer día como pasante en una empresa de marketing.\n\nMe daba miedo no saber nada, pero mi equipo me recibió muy bien y me asignaron una tarea pequeña para empezar. ¡Fue increíble!",
                'comentarios' => [
                    ['Miguel Torres', '¡Felicitaciones! Me alegra que hayas tenido una buena experiencia.'],
                ],
            ],
            [
                'autor' => 'Roberto Díaz', 'categoria' => 'consejos', 'hace' => 26, 'vistas' => 567,
                'titulo' => '5 consejos que me hubiera gustado saber antes de mi primer empleo',
                'contenido' => "Después de 6 meses en mi primer trabajo, estos son los consejos más importantes:\n\n1. Haz preguntas, nadie espera que lo sepas todo.\n2. Llega temprano los primeros días.\n3. Anota todo lo que te expliquen.\n4. Pide retroalimentación seguido.\n5. Cuida tu energía: descansar también es trabajar.",
                'comentarios' => [
                    ['Ana García', 'Excelentes consejos, especialmente el punto sobre hacer preguntas.'],
                    ['Sofía Ramírez', 'Guardado. El 3 me salvó más de una vez.'],
                    ['Laura Fernández', 'Yo agregaría: aprende los nombres de todos en la primera semana.'],
                ],
            ],
            [
                'autor' => 'Sofía Ramírez', 'categoria' => 'preguntas', 'hace' => 3, 'vistas' => 298,
                'titulo' => '¿Qué ropa debo usar para la entrevista?',
                'contenido' => 'Tengo una entrevista en una empresa de tecnología y no sé si ir formal o casual. ¿Ayuda?',
                'comentarios' => [
                    ['Carlos Martínez', 'Para empresas tech suele ser más casual, pero siempre es mejor ir semi-formal.'],
                ],
            ],
            [
                'autor' => 'Andrea Silva', 'categoria' => 'experiencias', 'hace' => 50, 'vistas' => 421,
                'titulo' => 'Cómo superé el síndrome del impostor en mi primer trabajo',
                'contenido' => "Al principio sentía que no era suficiente, pero con el tiempo aprendí a manejar esos pensamientos.\n\nLo que más me ayudó fue anotar cada semana una cosa que hice bien.",
                'comentarios' => [
                    ['Martín González', 'Gracias por compartir, yo también pasé por lo mismo al inicio.'],
                    ['Roberto Díaz', 'Anotar los logros semanales es una gran idea, la voy a copiar.'],
                ],
            ],
            [
                'autor' => 'Martín González', 'categoria' => 'entrevistas', 'hace' => 6, 'vistas' => 187,
                'titulo' => 'Tips para destacar en una entrevista grupal',
                'contenido' => 'Me llamaron para una entrevista grupal y nunca he estado en una. ¿Qué debo hacer?',
                'comentarios' => [
                    ['Andrea Silva', 'Lo importante es participar sin opacar a los demás. Muestra trabajo en equipo.'],
                ],
            ],
        ];

        foreach ($conversaciones as $c) {
            $autor = $personas[$c['autor']];
            $creado = now()->subHours($c['hace']);

            $post = ForoPost::forceCreate([
                'user_id' => $autor->id,
                'categoria' => $c['categoria'],
                'titulo' => $c['titulo'],
                'contenido' => $c['contenido'],
                'vistas' => $c['vistas'],
                'created_at' => $creado,
                'updated_at' => $creado,
            ]);

            foreach ($c['comentarios'] as $i => [$nombre, $texto]) {
                $momento = $creado->copy()->addMinutes(20 * ($i + 1));
                $comentario = ForoComentario::forceCreate([
                    'foro_post_id' => $post->id,
                    'user_id' => $personas[$nombre]->id,
                    'contenido' => $texto,
                    'created_at' => $momento,
                    'updated_at' => $momento,
                ]);

                $this->votar($comentario, $personas->except($nombre)->values());
            }

            $this->votar($post, $personas->except($c['autor'])->values());
        }

        $this->command?->info('Foro de ejemplo creado: ' . ForoPost::count() . ' publicaciones.');
    }

    /** Reparte algunos "me gusta" (y rara vez un "no me gusta") entre las personas de ejemplo. */
    private function votar($elemento, $candidatos): void
    {
        $cuantos = random_int(1, min(5, $candidatos->count()));

        foreach ($candidatos->random($cuantos) as $persona) {
            ForoVoto::forceCreate([
                'user_id' => $persona->id,
                'votable_type' => $elemento::class,
                'votable_id' => $elemento->id,
                'valor' => random_int(1, 10) === 1 ? ForoVoto::NO_ME_GUSTA : ForoVoto::ME_GUSTA,
            ]);
        }
    }
}
