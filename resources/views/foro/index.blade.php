<x-app-layout>

    @php
        // Conserva la búsqueda / categoría / orden al cambiar uno de ellos
        $enlace = fn (array $cambios) => route('foro', array_filter(array_merge(request()->except(['page']), $cambios), fn ($v) => $v !== null && $v !== ''));

        $tarjetas = [
            ['valor' => $stats['posts'], 'texto' => 'Posts totales', 'icono' => 'message-circle', 'fondo' => 'rgba(16, 55, 93, 0.1)', 'color' => '#10375d'],
            ['valor' => $stats['miembros'], 'texto' => 'Miembros activos', 'icono' => 'users', 'fondo' => 'rgba(109, 184, 187, 0.1)', 'color' => '#6db8bb'],
            ['valor' => $stats['hoy'], 'texto' => 'Posts hoy', 'icono' => 'trending-up', 'fondo' => 'rgba(5, 100, 122, 0.1)', 'color' => '#05647a'],
            ['valor' => $stats['respuestas'], 'texto' => 'Respuestas útiles', 'icono' => 'award', 'fondo' => 'rgba(134, 150, 132, 0.1)', 'color' => '#869684'],
        ];

        $emojiCategoria = ['experiencias' => '🌟', 'preguntas' => '❓', 'consejos' => '💡', 'entrevistas' => '🎤'];

        $pestanaClase = 'whitespace-nowrap rounded-lg px-4 py-2 text-sm transition-colors';
    @endphp

    <div class="oj-page"
         x-data="{ abierto: {{ $errors->hasAny(['categoria', 'titulo', 'contenido']) ? 'true' : 'false' }} }"
         @keydown.escape.window="abierto = false">
        <div class="oj-container py-8">

            @if (session('status'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-2 text-sm text-green-700">{{ session('status') }}</div>
            @endif

            {{-- Encabezado --}}
            <div class="mb-8">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <h1 class="oj-title">Foro de la Comunidad</h1>
                        <p class="text-gray-600">Comparte experiencias y aprende de otros jóvenes profesionales</p>
                    </div>

                    @auth
                        <button type="button" @click="abierto = true" class="oj-btn-gradient">
                            <x-icon name="plus" class="h-4 w-4" />
                            Nuevo Post
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="oj-btn-gradient">
                            <x-icon name="plus" class="h-4 w-4" />
                            Inicia sesión para publicar
                        </a>
                    @endauth
                </div>

                {{-- Estadísticas --}}
                <div class="mb-6 grid gap-4 sm:grid-cols-4">
                    @foreach ($tarjetas as $tarjeta)
                        <div class="oj-card flex items-center gap-3 p-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg" style="background-color: {{ $tarjeta['fondo'] }};">
                                <x-icon :name="$tarjeta['icono']" class="h-5 w-5" style="color: {{ $tarjeta['color'] }};" />
                            </div>
                            <div>
                                <div class="text-2xl">{{ number_format($tarjeta['valor'], 0, ',', '.') }}</div>
                                <div class="text-xs text-gray-600">{{ $tarjeta['texto'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- ============ Columna principal ============ --}}
                <div class="space-y-6 lg:col-span-2">

                    {{-- Buscador y categorías --}}
                    <div class="oj-card p-4">
                        <form method="GET" action="{{ route('foro') }}" class="flex gap-3">
                            @if ($categoriaActual)
                                <input type="hidden" name="categoria" value="{{ $categoriaActual }}">
                            @endif
                            @if ($orden === 'populares')
                                <input type="hidden" name="orden" value="populares">
                            @endif

                            <div class="relative flex-1">
                                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" />
                                <input type="text" name="q" value="{{ $busqueda }}" placeholder="Buscar en el foro..." class="oj-input pl-10">
                            </div>
                            <button type="submit" class="oj-btn-outline w-9 px-0" title="Buscar">
                                <x-icon name="filter" class="h-4 w-4" />
                            </button>
                        </form>

                        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
                            <a href="{{ $enlace(['categoria' => null]) }}"
                               class="{{ $pestanaClase }} {{ $categoriaActual === null ? 'bg-oj-accent text-white' : 'bg-oj-bg text-oj-primary hover:bg-oj-bg/70' }}">
                                Todos ({{ $totalPosts }})
                            </a>
                            @foreach ($categorias as $clave => $etiqueta)
                                <a href="{{ $enlace(['categoria' => $clave]) }}"
                                   class="{{ $pestanaClase }} {{ $categoriaActual === $clave ? 'bg-oj-accent text-white' : 'bg-oj-bg text-oj-primary hover:bg-oj-bg/70' }}">
                                    {{ $etiqueta }} ({{ $porCategoria[$clave] ?? 0 }})
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Orden --}}
                    <div class="flex items-center justify-between text-sm">
                        <p class="text-gray-600">{{ $posts->total() }} {{ $posts->total() === 1 ? 'publicación' : 'publicaciones' }}</p>
                        <div class="flex gap-2">
                            <a href="{{ $enlace(['orden' => 'populares']) }}"
                               class="oj-btn-ghost oj-btn-sm {{ $orden === 'populares' ? 'bg-oj-bg' : '' }}">
                                <x-icon name="trending-up" class="h-4 w-4" />
                                Populares
                            </a>
                            <a href="{{ $enlace(['orden' => null]) }}"
                               class="oj-btn-ghost oj-btn-sm {{ $orden === 'recientes' ? 'bg-oj-bg' : '' }}">
                                <x-icon name="clock" class="h-4 w-4" />
                                Recientes
                            </a>
                        </div>
                    </div>

                    {{-- Publicaciones --}}
                    <div class="space-y-4">
                        @forelse ($posts as $post)
                            @php
                                $respuesta = $post->ultimoComentario;
                                $nuevasRespuestas = $respuesta && $respuesta->created_at->gt(now()->subDay());
                            @endphp

                            <article id="post-{{ $post->id }}" class="oj-card p-6 transition-shadow hover:shadow-md">
                                <div class="flex gap-4">
                                    <x-foro.avatar :usuario="$post->autor" />

                                    <div class="min-w-0 flex-1">
                                        <div class="mb-2">
                                            <div class="mb-1 flex flex-wrap items-center gap-2">
                                                <x-foro.categoria :categoria="$post->categoria" />
                                                @if ($post->likes_count >= 4)
                                                    <span class="oj-badge border-orange-300 text-orange-700">
                                                        <x-icon name="award" class="h-3 w-3" />
                                                        Destacado
                                                    </span>
                                                @endif
                                                @if ($nuevasRespuestas)
                                                    <span class="oj-badge border-oj-accent text-oj-accent">Nuevas respuestas</span>
                                                @endif
                                            </div>

                                            <h3 class="mb-1 text-lg text-oj-primary transition-colors hover:opacity-80">
                                                <a href="{{ route('foro.show', $post) }}">{{ $post->titulo }}</a>
                                            </h3>

                                            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                                                <span>{{ $post->autor->name }}</span>
                                                <span>•</span>
                                                <span class="text-xs">{{ $post->autor->esAdmin() ? 'Administrador' : 'Miembro' }}</span>
                                                <span>•</span>
                                                <span class="text-xs">{{ $post->created_at->locale('es')->diffForHumans() }}</span>
                                            </div>
                                        </div>

                                        <p class="mb-3 line-clamp-2 break-words text-sm text-gray-600">{{ $post->contenido }}</p>

                                        {{-- Vista previa de la última respuesta --}}
                                        @if ($respuesta)
                                            <a href="{{ route('foro.show', $post) }}#comentarios" class="mb-3 block rounded-lg bg-gray-50 p-3 transition-colors hover:bg-gray-100">
                                                <p class="mb-1 text-xs text-gray-500">Respuesta de {{ $respuesta->autor->name }}:</p>
                                                <p class="line-clamp-2 break-words text-sm text-gray-700">{{ $respuesta->contenido }}</p>
                                            </a>
                                        @endif

                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            <a href="{{ route('foro.show', $post) }}#comentarios" class="flex items-center gap-1 transition-colors hover:text-blue-600">
                                                <x-icon name="message-circle" class="h-4 w-4" />
                                                <span>{{ $post->comentarios_count }}</span>
                                            </a>

                                            <x-foro.votos :item="$post" tipo="post" />

                                            <span class="flex items-center gap-1">
                                                <x-icon name="eye" class="h-4 w-4" />
                                                <span>{{ $post->vistas }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-xl border border-dashed border-oj-muted bg-white p-10 text-center text-sm text-gray-500">
                                @if ($busqueda !== '' || $categoriaActual)
                                    No encontramos publicaciones con esos filtros.
                                @else
                                    Todavía no hay publicaciones. ¡Sé la primera persona en escribir!
                                @endif
                            </div>
                        @endforelse
                    </div>

                    <div>{{ $posts->links() }}</div>
                </div>

                {{-- ============ Barra lateral ============ --}}
                <div class="space-y-6">

                    {{-- Reglas --}}
                    <div class="rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50 to-purple-50 p-6">
                        <h4 class="mb-6 flex items-center gap-2 text-base leading-none">
                            <x-icon name="award" class="h-5 w-5 text-blue-600" />
                            Reglas de la comunidad
                        </h4>
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach (['Sé respetuoso con todos', 'Comparte experiencias reales', 'Ayuda a otros miembros', 'No spam ni publicidad'] as $regla)
                                <li class="flex items-start gap-2">
                                    <span class="text-blue-600">✓</span>
                                    <span>{{ $regla }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Temas populares --}}
                    <div class="oj-card p-6">
                        <h4 class="mb-6 flex items-center gap-2 text-base leading-none">
                            <x-icon name="trending-up" class="h-5 w-5" />
                            Temas populares
                        </h4>

                        <div class="space-y-3">
                            @forelse ($temasPopulares as $tema)
                                <a href="{{ route('foro.show', $tema) }}" class="block w-full rounded-lg border border-gray-100 p-3 text-left transition-colors hover:bg-gray-50">
                                    <div class="flex items-center gap-3">
                                        <span class="text-2xl">{{ $emojiCategoria[$tema->categoria] ?? '💬' }}</span>
                                        <div class="min-w-0 flex-1">
                                            <p class="mb-1 line-clamp-2 text-sm">{{ $tema->titulo }}</p>
                                            <p class="text-xs text-gray-500">{{ $tema->comentarios_count }} {{ $tema->comentarios_count === 1 ? 'respuesta' : 'respuestas' }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-gray-500">Aún no hay temas.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Top contribuidores --}}
                    <div class="oj-card p-6">
                        <h4 class="mb-6 flex items-center gap-2 text-base leading-none">
                            <x-icon name="users" class="h-5 w-5" />
                            Top contribuidores
                        </h4>

                        <div class="space-y-3">
                            @forelse ($topContribuidores as $puesto)
                                <div class="flex items-center gap-3">
                                    <x-foro.avatar :usuario="$puesto['usuario']" size="h-8 w-8 text-xs" />
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm">{{ $puesto['usuario']->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $puesto['total'] }} {{ $puesto['total'] === 1 ? 'aporte' : 'aportes' }}</p>
                                    </div>
                                    <span class="text-xl">{{ ['🏆', '🥈', '🥉'][$loop->index] }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Aún no hay aportes.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Primera vez --}}
                    <div x-data="{ guia: false }" class="rounded-xl border border-green-200 bg-gradient-to-br from-green-50 to-blue-50 p-6">
                        <h4 class="mb-6 text-base leading-none">¿Primera vez aquí?</h4>
                        <p class="mb-4 text-sm text-gray-700">Lee nuestra guía para aprovechar al máximo la comunidad</p>

                        <ol x-show="guia" x-cloak class="mb-4 list-inside list-decimal space-y-2 text-sm text-gray-700">
                            <li>Busca primero: tal vez alguien ya preguntó lo mismo.</li>
                            <li>Elige la categoría correcta para tu publicación.</li>
                            <li>Usa un título claro que resuma tu duda o experiencia.</li>
                            <li>Dale «me gusta» a las respuestas que te sirvan.</li>
                        </ol>

                        <button type="button" @click="guia = !guia" class="oj-btn-outline w-full">
                            <span x-text="guia ? 'Ocultar guía' : 'Ver guía de inicio'">Ver guía de inicio</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ Ventana: nueva publicación ============ --}}
        @auth
            <div x-show="abierto" x-transition.opacity x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true">
                <div @click.outside="abierto = false" class="w-full max-w-xl rounded-lg border bg-white p-6 shadow-lg">
                    <h2 class="text-lg leading-none">Crear nueva publicación</h2>
                    <p class="mt-2 text-sm text-oj-muted">Comparte tu experiencia, haz una pregunta o da consejos a la comunidad</p>

                    <form method="POST" action="{{ route('foro.store') }}" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <label for="categoria" class="mb-2 block text-sm">Categoría</label>
                            <select id="categoria" name="categoria" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                                @foreach ($categorias as $clave => $etiqueta)
                                    <option value="{{ $clave }}" @selected(old('categoria', 'preguntas') === $clave)>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            @error('categoria') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="titulo" class="mb-2 block text-sm">Título</label>
                            <input id="titulo" type="text" name="titulo" value="{{ old('titulo') }}" maxlength="150" placeholder="¿De qué quieres hablar?" class="oj-input">
                            @error('titulo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="contenido" class="mb-2 block text-sm">Contenido</label>
                            <textarea id="contenido" name="contenido" rows="6" maxlength="5000" placeholder="Comparte tu historia, pregunta o consejo..."
                                      class="oj-input">{{ old('contenido') }}</textarea>
                            @error('contenido') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="oj-btn-gradient flex-1">Publicar</button>
                            <button type="button" @click="abierto = false" class="oj-btn-outline">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        @endauth
    </div>

</x-app-layout>
