<?php

namespace Tests\Feature;

use App\Models\ForoComentario;
use App\Models\ForoPost;
use App\Models\ForoVoto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ForoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite(); // las pruebas no necesitan los estilos compilados
    }

    private function crearPost(array $datos = []): ForoPost
    {
        return ForoPost::create($datos + [
            'user_id' => User::factory()->create()->id,
            'categoria' => 'preguntas',
            'titulo' => '¿Cómo preparo mi primera entrevista?',
            'contenido' => 'Tengo mi primera entrevista la próxima semana y estoy nervioso.',
        ]);
    }

    public function test_cualquiera_puede_ver_el_foro_y_una_publicacion(): void
    {
        $post = $this->crearPost();

        $this->get('/foro')->assertOk()->assertSee('Foro de la Comunidad')->assertSee($post->titulo);
        $this->get('/foro/' . $post->id)->assertOk()->assertSee($post->titulo)->assertSee('para comentar y votar');
    }

    public function test_una_publicacion_inexistente_da_404(): void
    {
        $this->get('/foro/999')->assertNotFound();
    }

    public function test_sin_sesion_no_se_puede_publicar_comentar_ni_votar(): void
    {
        $post = $this->crearPost();

        $this->post('/foro', ['categoria' => 'preguntas', 'titulo' => 'Titulo valido', 'contenido' => 'Contenido de prueba'])->assertRedirect('/login');
        $this->post("/foro/{$post->id}/comentarios", ['contenido' => 'Hola'])->assertRedirect('/login');
        $this->post("/foro/votar/post/{$post->id}", ['valor' => 1])->assertRedirect('/login');

        $this->assertSame(1, ForoPost::count());
        $this->assertSame(0, ForoVoto::count());
    }

    public function test_se_puede_crear_una_publicacion(): void
    {
        $user = User::factory()->create();

        $respuesta = $this->actingAs($user)->post('/foro', [
            'categoria' => 'consejos',
            'titulo' => 'Cinco consejos para tu primer empleo',
            'contenido' => 'Pregunta mucho y llega temprano.',
        ]);

        $post = ForoPost::first();
        $respuesta->assertRedirect(route('foro.show', $post));
        $this->assertSame($user->id, $post->user_id);
        $this->assertSame('consejos', $post->categoria);
    }

    public function test_la_publicacion_se_valida(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/foro', ['categoria' => 'inventada', 'titulo' => 'abc', 'contenido' => 'corto'])
            ->assertSessionHasErrors(['categoria', 'titulo', 'contenido']);

        $this->assertSame(0, ForoPost::count());
    }

    public function test_se_puede_comentar_y_se_valida_el_comentario(): void
    {
        $post = $this->crearPost();
        $user = User::factory()->create();

        $this->actingAs($user)->post("/foro/{$post->id}/comentarios", ['contenido' => ''])->assertSessionHasErrors('contenido');

        $this->actingAs($user)->post("/foro/{$post->id}/comentarios", ['contenido' => 'Sé tú mismo y llega temprano.'])
            ->assertRedirect();

        $this->assertSame(1, $post->comentarios()->count());
        $this->get('/foro/' . $post->id)->assertSee('Sé tú mismo y llega temprano.')->assertSee('1 comentario');
    }

    public function test_me_gusta_se_quita_al_repetir_y_cambia_al_votar_lo_contrario(): void
    {
        $post = $this->crearPost();
        $user = User::factory()->create();

        // me gusta
        $this->actingAs($user)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);
        $this->assertSame(1, $post->votos()->where('valor', 1)->count());

        // otra vez me gusta = lo quita
        $this->actingAs($user)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);
        $this->assertSame(0, $post->votos()->count());

        // me gusta y luego no me gusta = cambia (sigue habiendo un solo voto)
        $this->actingAs($user)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);
        $this->actingAs($user)->post("/foro/votar/post/{$post->id}", ['valor' => -1]);
        $this->assertSame(1, $post->votos()->count());
        $this->assertSame(-1, $post->votos()->first()->valor);
    }

    public function test_cada_persona_cuenta_un_solo_voto_y_los_totales_se_muestran(): void
    {
        $post = $this->crearPost();
        [$a, $b, $c] = User::factory()->count(3)->create();

        $this->actingAs($a)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);
        $this->actingAs($b)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);
        $this->actingAs($c)->post("/foro/votar/post/{$post->id}", ['valor' => -1]);

        $mostrado = ForoPost::conVotos()->find($post->id);
        $this->assertSame(2, $mostrado->likes_count);
        $this->assertSame(1, $mostrado->dislikes_count);
    }

    public function test_tambien_se_vota_en_los_comentarios(): void
    {
        $post = $this->crearPost();
        $comentario = ForoComentario::create(['foro_post_id' => $post->id, 'user_id' => $post->user_id, 'contenido' => 'Buen consejo']);
        $user = User::factory()->create();

        $this->actingAs($user)->post("/foro/votar/comentario/{$comentario->id}", ['valor' => 1])->assertRedirect();

        $this->assertSame(1, $comentario->votos()->count());
        $this->assertSame(0, $post->votos()->count()); // no se mezcla con los votos de la publicación
    }

    public function test_no_se_puede_votar_con_datos_invalidos(): void
    {
        $post = $this->crearPost();
        $user = User::factory()->create();

        $this->actingAs($user)->post("/foro/votar/post/{$post->id}", ['valor' => 5])->assertSessionHasErrors('valor');
        $this->actingAs($user)->post("/foro/votar/usuarios/{$user->id}", ['valor' => 1])->assertNotFound();
        $this->actingAs($user)->post('/foro/votar/post/999', ['valor' => 1])->assertNotFound();
        $this->assertSame(0, ForoVoto::count());
    }

    public function test_solo_el_autor_o_un_admin_borra_una_publicacion(): void
    {
        $post = $this->crearPost();
        $otro = User::factory()->create();

        $this->actingAs($otro)->delete("/foro/{$post->id}")->assertForbidden();
        $this->assertSame(1, ForoPost::count());

        $this->actingAs($post->autor)->delete("/foro/{$post->id}")->assertRedirect(route('foro'));
        $this->assertSame(0, ForoPost::count());
    }

    public function test_un_admin_puede_borrar_cualquier_publicacion(): void
    {
        $post = $this->crearPost();
        $admin = User::factory()->create(['email' => 'jefa@correo.com']);
        config(['oportunidad.admin_emails' => ['jefa@correo.com']]);

        $this->actingAs($admin)->delete("/foro/{$post->id}")->assertRedirect(route('foro'));
        $this->assertSame(0, ForoPost::count());
    }

    public function test_al_borrar_una_publicacion_se_borran_sus_comentarios_y_votos(): void
    {
        $post = $this->crearPost();
        $lector = User::factory()->create();
        $comentario = ForoComentario::create(['foro_post_id' => $post->id, 'user_id' => $lector->id, 'contenido' => 'Hola']);

        $this->actingAs($lector)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);
        $this->actingAs($lector)->post("/foro/votar/comentario/{$comentario->id}", ['valor' => 1]);
        $this->assertSame(2, ForoVoto::count());

        $this->actingAs($post->autor)->delete("/foro/{$post->id}");

        $this->assertSame(0, ForoComentario::count());
        $this->assertSame(0, ForoVoto::count());
    }

    public function test_solo_el_autor_o_un_admin_borra_un_comentario(): void
    {
        $post = $this->crearPost();
        $autor = User::factory()->create();
        $otro = User::factory()->create();
        $comentario = ForoComentario::create(['foro_post_id' => $post->id, 'user_id' => $autor->id, 'contenido' => 'Hola']);

        $this->actingAs($otro)->delete("/foro/comentarios/{$comentario->id}")->assertForbidden();
        $this->assertSame(1, ForoComentario::count());

        $this->actingAs($autor)->delete("/foro/comentarios/{$comentario->id}")->assertRedirect();
        $this->assertSame(0, ForoComentario::count());
    }

    public function test_las_vistas_se_cuentan_una_vez_por_sesion(): void
    {
        $post = $this->crearPost();

        $this->get("/foro/{$post->id}");
        $this->get("/foro/{$post->id}");

        $this->assertSame(1, $post->fresh()->vistas);
    }

    public function test_se_filtra_por_categoria_y_se_busca_por_texto(): void
    {
        $this->crearPost(['categoria' => 'consejos', 'titulo' => 'Consejos para el CV']);
        $this->crearPost(['categoria' => 'preguntas', 'titulo' => 'Pregunta sobre salarios']);

        // Se revisa el listado en sí (la barra lateral siempre muestra temas de todas las categorías)
        $this->get('/foro?categoria=consejos')->assertViewHas('posts', fn ($posts) => $posts->total() === 1 && $posts->first()->titulo === 'Consejos para el CV');
        $this->get('/foro?q=salarios')->assertViewHas('posts', fn ($posts) => $posts->total() === 1 && $posts->first()->titulo === 'Pregunta sobre salarios');
        $this->get('/foro?q=nadaquecoincida')->assertViewHas('posts', fn ($posts) => $posts->total() === 0)->assertSee('No encontramos publicaciones');
    }

    public function test_populares_ordena_por_me_gusta(): void
    {
        $poco = $this->crearPost(['titulo' => 'Publicación con pocos votos']);
        $mucho = $this->crearPost(['titulo' => 'Publicación muy querida']);
        [$a, $b] = User::factory()->count(2)->create();

        foreach ([$a, $b] as $u) {
            $this->actingAs($u)->post("/foro/votar/post/{$mucho->id}", ['valor' => 1]);
        }

        $this->get('/foro?orden=populares')->assertSeeInOrder(['Publicación muy querida', 'Publicación con pocos votos']);
    }

    public function test_con_sesion_se_marca_el_voto_propio(): void
    {
        $post = $this->crearPost();
        $user = User::factory()->create();
        $this->actingAs($user)->post("/foro/votar/post/{$post->id}", ['valor' => 1]);

        $html = $this->actingAs($user)->get('/foro/' . $post->id)->getContent();
        $this->assertStringContainsString('aria-pressed="true"', $html);
    }

    public function test_el_contenido_se_escapa_para_evitar_codigo_malicioso(): void
    {
        $post = $this->crearPost(['contenido' => '<script>alert("xss")</script> texto largo de prueba']);

        $this->get('/foro/' . $post->id)->assertDontSee('<script>alert("xss")</script>', false);
    }

    public function test_el_seeder_de_ejemplo_crea_conversaciones_y_las_pantallas_se_ven(): void
    {
        $this->seed(\Database\Seeders\ForoSeeder::class);

        $this->assertSame(6, ForoPost::count());
        $this->assertGreaterThan(0, ForoComentario::count());
        $this->assertGreaterThan(0, ForoVoto::count());

        $this->get('/foro')->assertOk()->assertSee('Top contribuidores')->assertSee('Temas populares');
        $this->get('/foro/' . ForoPost::first()->id)->assertOk();

        // Si se corre otra vez no duplica nada
        $this->seed(\Database\Seeders\ForoSeeder::class);
        $this->assertSame(6, ForoPost::count());
    }

    public function test_parametros_raros_en_la_url_no_rompen_el_foro(): void
    {
        $this->crearPost();

        $this->get('/foro?categoria[]=x&orden[]=y&q[]=z')->assertOk();
        $this->get('/foro?categoria=inventada')->assertOk()->assertViewHas('posts', fn ($posts) => $posts->total() === 1);
    }
}
