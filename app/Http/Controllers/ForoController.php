<?php

namespace App\Http\Controllers;

use App\Models\ForoComentario;
use App\Models\ForoPost;
use App\Models\ForoVoto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ForoController extends Controller
{
    /** Listado de publicaciones con búsqueda, categorías y orden. */
    public function index(Request $request): View
    {
        $userId = $request->user()?->id;

        $busqueda = is_string($request->input('q')) ? trim($request->input('q')) : '';
        $categoria = is_string($request->input('categoria')) && array_key_exists($request->input('categoria'), ForoPost::CATEGORIAS)
            ? $request->input('categoria')
            : null;
        $orden = $request->input('orden') === 'populares' ? 'populares' : 'recientes';

        $posts = ForoPost::query()
            ->with('autor')
            ->withCount('comentarios')
            ->conVotos($userId)
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($q) use ($busqueda) {
                    $q->where('titulo', 'like', '%' . $busqueda . '%')
                      ->orWhere('contenido', 'like', '%' . $busqueda . '%');
                });
            })
            ->when($categoria, fn ($query) => $query->where('categoria', $categoria))
            ->when(
                $orden === 'populares',
                fn ($query) => $query->orderByDesc('likes_count')->orderByDesc('comentarios_count')->latest(),
                fn ($query) => $query->latest()
            )
            ->paginate(8)
            ->withQueryString();

        // Cuántas publicaciones tiene cada categoría (para los botones de arriba)
        $porCategoria = ForoPost::select('categoria', DB::raw('count(*) as total'))
            ->groupBy('categoria')
            ->pluck('total', 'categoria');

        return view('foro.index', [
            'posts' => $posts,
            'categorias' => ForoPost::CATEGORIAS,
            'porCategoria' => $porCategoria,
            'totalPosts' => $porCategoria->sum(),
            'busqueda' => $busqueda,
            'categoriaActual' => $categoria,
            'orden' => $orden,
            'stats' => [
                'posts' => $porCategoria->sum(),
                'miembros' => User::count(),
                'hoy' => ForoPost::whereDate('created_at', today())->count(),
                'respuestas' => ForoComentario::count(),
            ],
            'temasPopulares' => ForoPost::withCount('comentarios')
                ->orderByDesc('comentarios_count')
                ->latest()
                ->take(4)
                ->get(),
            'topContribuidores' => $this->topContribuidores(),
        ]);
    }

    /** Una publicación con todos sus comentarios. */
    public function show(Request $request, int $post): View
    {
        $userId = $request->user()?->id;

        $post = ForoPost::with('autor')
            ->withCount('comentarios')
            ->conVotos($userId)
            ->findOrFail($post);

        // Suma una vista por sesión (así recargar la página no infla el contador)
        $clave = 'foro_visto.' . $post->id;
        if (! $request->session()->has($clave)) {
            $post->increment('vistas');
            $request->session()->put($clave, true);
        }

        $comentarios = ForoComentario::where('foro_post_id', $post->id)
            ->with('autor')
            ->conVotos($userId)
            ->oldest()
            ->paginate(20)
            ->withQueryString();

        return view('foro.show', compact('post', 'comentarios'));
    }

    /** Crear una publicación nueva. */
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'categoria' => ['required', Rule::in(array_keys(ForoPost::CATEGORIAS))],
            'titulo' => ['required', 'string', 'min:5', 'max:150'],
            'contenido' => ['required', 'string', 'min:10', 'max:5000'],
        ]);

        $post = ForoPost::create($datos + ['user_id' => $request->user()->id]);

        return redirect()->route('foro.show', $post)->with('status', 'Tu publicación quedó en el foro.');
    }

    /** Borrar una publicación (solo su autor o un administrador). */
    public function destroy(Request $request, ForoPost $post): RedirectResponse
    {
        $this->autorizarBorrado($request, $post->user_id);

        $post->delete();

        return redirect()->route('foro')->with('status', 'La publicación se eliminó.');
    }

    /** Comentar una publicación. */
    public function comentar(Request $request, ForoPost $post): RedirectResponse
    {
        $datos = $request->validate([
            'contenido' => ['required', 'string', 'min:2', 'max:2000'],
        ]);

        $comentario = $post->comentarios()->create($datos + ['user_id' => $request->user()->id]);

        return redirect(route('foro.show', $post) . '#comentario-' . $comentario->id)
            ->with('status', 'Tu comentario se publicó.');
    }

    /** Borrar un comentario (solo su autor o un administrador). */
    public function destroyComentario(Request $request, ForoComentario $comentario): RedirectResponse
    {
        $this->autorizarBorrado($request, $comentario->user_id);

        $post = $comentario->foro_post_id;
        $comentario->delete();

        return redirect(route('foro.show', $post) . '#comentarios')->with('status', 'El comentario se eliminó.');
    }

    /**
     * Me gusta / No me gusta sobre una publicación o un comentario.
     *  - Tocar el mismo botón otra vez quita el voto.
     *  - Tocar el contrario cambia el voto.
     */
    public function votar(Request $request, string $tipo, int $id): RedirectResponse
    {
        $request->validate([
            'valor' => ['required', Rule::in([ForoVoto::ME_GUSTA, ForoVoto::NO_ME_GUSTA])],
        ]);
        $valor = (int) $request->input('valor');

        // Solo se aceptan estos dos tipos (así nadie puede votar sobre otras tablas)
        $modelo = match ($tipo) {
            'post' => ForoPost::class,
            'comentario' => ForoComentario::class,
            default => abort(404),
        };

        $elemento = $modelo::findOrFail($id);
        $voto = $elemento->votos()->where('user_id', $request->user()->id)->first();

        if ($voto && $voto->valor === $valor) {
            $voto->delete();
        } elseif ($voto) {
            $voto->update(['valor' => $valor]);
        } else {
            $elemento->votos()->create(['user_id' => $request->user()->id, 'valor' => $valor]);
        }

        // Volver a la misma página, justo en la tarjeta donde se votó
        return redirect(url()->previous() . '#' . $tipo . '-' . $id);
    }

    private function autorizarBorrado(Request $request, int $autorId): void
    {
        $usuario = $request->user();

        abort_unless($usuario->id === $autorId || $usuario->esAdmin(), 403, 'No puedes eliminar esto.');
    }

    /** Las 3 personas que más publican y comentan. */
    private function topContribuidores()
    {
        $conteo = [];

        $porPosts = ForoPost::select('user_id', DB::raw('count(*) as total'))->groupBy('user_id')->pluck('total', 'user_id');
        $porComentarios = ForoComentario::select('user_id', DB::raw('count(*) as total'))->groupBy('user_id')->pluck('total', 'user_id');

        foreach ([$porPosts, $porComentarios] as $grupo) {
            foreach ($grupo as $id => $total) {
                $conteo[$id] = ($conteo[$id] ?? 0) + $total;
            }
        }

        arsort($conteo);
        $ids = array_slice(array_keys($conteo), 0, 3);
        $usuarios = User::whereIn('id', $ids)->get()->keyBy('id');

        return collect($ids)->map(fn ($id) => [
            'usuario' => $usuarios[$id],
            'total' => $conteo[$id],
        ]);
    }
}
