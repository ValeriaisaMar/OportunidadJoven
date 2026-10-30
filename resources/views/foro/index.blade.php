<x-app-layout>

    @php
        // Conserva la búsqueda / categoría / orden al cambiar uno de ellos
        $enlace = fn (array $cambios) => route('foro', array_filter(array_merge(request()->except(['page']), $cambios), fn ($v) => $v !== null && $v !== ''));

        $tarjetas = [
            ['valor' => $stats['posts'], 'texto' => 'Posts totales', 'icono' => 'message-circle', 'color' => 'bg-[#10375d]/10 text-[#10375d]'],
            ['valor' => $stats['miembros'], 'texto' => 'Miembros', 'icono' => 'users', 'color' => 'bg-[#6db8bb]/20 text-[#05647a]'],
            ['valor' => $stats['hoy'], 'texto' => 'Posts hoy', 'icono' => 'trending-up', 'color' => 'bg-[#05647a]/10 text-[#05647a]'],
            ['valor' => $stats['respuestas'], 'texto' => 'Respuestas', 'icono' => 'award', 'color' => 'bg-[#869684]/20 text-[#869684]'],
        ];
    @endphp

    <section class="oj-section py-10"
             x-data="{ abierto: {{ $errors->hasAny(['categoria', 'titulo', 'contenido']) ? 'true' : 'false' }} }"
             @keydown.escape.window="abierto = false">
        <div class="oj-container">

            @if (session('status'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-2 text-sm text-green-700">{{ session('status') }}</div>
            @endif

            {{-- Encabezado --}}
            <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="mb-2 text-3xl font-bold text-[#10375d]">Foro de la Comunidad</h1>
                    <p class="text-gray-600">Comparte experiencias y aprende de otros jóvenes profesionales</p>
                </div>

                @auth
                    <button type="button" @click="abierto = true"
                            class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                            style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%)">
                        <x-icon name="plus" class="h-4 w-4" />
                        Nuevo Post
                    </button>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                       style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%)">
                        <x-icon name="plus" class="h-4 w-4" />
                        Inicia sesión para publicar
                    </a>
                @endauth
            </div>

            {{-- Estadísticas --}}
            <div class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($tarjetas as $tarjeta)
                    <div class="flex items-center gap-3 rounded-xl border border-[#869684]/50 bg-white p-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg {{ $tarjeta['color'] }}">
                            <x-icon :name="$tarjeta['icono']" class="h-5 w-5" />
                        </div>
                        <div>
                            <div class="text-2xl font-semibold text-[#10375d]">{{ number_format($tarjeta['valor'], 0, ',', '.') }}</div>
                            <div class="text-xs text-gray-600">{{ $tarjeta['texto'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="grid gap-6 lg:grid-cols-3">

                {{-- ============ Columna principal ============ --}}
                <div class="space-y-6 lg:col-span-2">

                    {{-- Buscador y categorías --}}
                    <div class="rounded-xl border border-[#869684]/50 bg-white p-4">
                        <form method="GET" action="{{ route('foro') }}" class="flex gap-3">
                            @if ($categoriaActual)
                                <input type="hidden" name="categoria" value="{{ $categoriaActual }}">
                            @endif
                            @if ($orden === 'populares')
                                <input type="hidden" name="orden" value="populares">
                            @endif

                            <div class="relative flex-1">
                                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500" />
                                <input type="text" name="q" value="{{ $busqueda }}" placeholder="Buscar en el foro..."
                                       class="w-full rounded-md border-0 bg-[#e0e2d5] py-2 pl-10 pr-3 text-sm text-[#10375d] placeholder:text-gray-500 focus:ring-2 focus:ring-[#6db8bb]">
                            </div>
                            <button type="submit" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                                Buscar
                            </button>
                        </form>

                        <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
                            <a href="{{ $enlace(['categoria' => null]) }}"
                               class="whitespace-nowrap rounded-lg px-4 py-2 text-sm transition-colors {{ $categoriaActual === null ? 'bg-[#05647a] text-white' : 'bg-[#e0e2d5] text-[#10375d] hover:bg-[#e0e2d5]/70' }}">
                                Todos ({{ $totalPosts }})
                            </a>
                            @foreach ($categorias as $clave => $etiqueta)
                                <a href="{{ $enlace(['categoria' => $clave]) }}"
                                   class="whitespace-nowrap rounded-lg px-4 py-2 text-sm transition-colors {{ $categoriaActual === $clave ? 'bg-[#05647a] text-white' : 'bg-[#e0e2d5] text-[#10375d] hover:bg-[#e0e2d5]/70' }}">
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
                               class="inline-flex items-center gap-2 rounded-md px-3 py-1.5 {{ $orden === 'populares' ? 'bg-[#e0e2d5] font-medium text-[#10375d]' : 'text-[#10375d]/70 hover:bg-gray-100' }}">
                                <x-icon name="trending-up" class="h-4 w-4" />
                                Populares
                            </a>
                            <a href="{{ $enlace(['orden' => null]) }}"
                               class="inline-flex items-center gap-2 rounded-md px-3 py-1.5 {{ $orden === 'recientes' ? 'bg-[#e0e2d5] font-medium text-[#10375d]' : 'text-[#10375d]/70 hover:bg-gray-100' }}">
                                <x-icon name="clock" class="h-4 w-4" />
                                Recientes
                            </a>
                        </div>
                    </div>

                    {{-- Publicaciones --}}
                    <div class="space-y-4">
                        @forelse ($posts as $post)
                            <article id="post-{{ $post->id }}" class="rounded-xl border border-[#869684]/50 bg-white p-6 transition-shadow hover:shadow-md">
                                <div class="flex gap-4">
                                    <x-foro.avatar :usuario="$post->autor" />

                                    <div class="min-w-0 flex-1">
                                        <div class="mb-1"><x-foro.categoria :categoria="$post->categoria" /></div>

                                        <h2 class="text-lg font-medium text-[#10375d]">
                                            <a href="{{ route('foro.show', $post) }}" class="hover:underline">{{ $post->titulo }}</a>
                                        </h2>

                                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                            <span class="text-sm text-gray-600">{{ $post->autor->name }}</span>
                                            <span>•</span>
                                            <span>{{ $post->autor->esAdmin() ? 'Administrador' : 'Miembro' }}</span>
                                            <span>•</span>
                                            <span>{{ $post->created_at->locale('es')->diffForHumans() }}</span>
                                        </div>

                                        <p class="my-3 line-clamp-2 break-words text-sm text-gray-600">{{ $post->contenido }}</p>

                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                            <x-foro.votos :item="$post" tipo="post" />

                                            <a href="{{ route('foro.show', $post) }}#comentarios" class="inline-flex items-center gap-1 hover:text-[#05647a]">
                                                <x-icon name="message-circle" class="h-4 w-4" />
                                                {{ $post->comentarios_count }}
                                            </a>

                                            <span class="inline-flex items-center gap-1">
                                                <x-icon name="eye" class="h-4 w-4" />
                                                {{ $post->vistas }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-xl border border-dashed border-[#869684] bg-white p-10 text-center text-sm text-gray-500">
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

                    <div class="rounded-xl border border-[#869684]/50 bg-[#e0e2d5]/50 p-6">
                        <h3 class="mb-3 flex items-center gap-2 text-base font-semibold text-[#10375d]">
                            <x-icon name="award" class="h-5 w-5 text-[#05647a]" />
                            Reglas de la comunidad
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-700">
                            @foreach (['Sé respetuoso con todos', 'Comparte experiencias reales', 'Ayuda a otros miembros', 'No spam ni publicidad'] as $regla)
                                <li class="flex items-start gap-2">
                                    <x-icon name="check" class="mt-0.5 h-4 w-4 text-[#05647a]" />
                                    <span>{{ $regla }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="rounded-xl border border-[#869684]/50 bg-white p-6">
                        <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-[#10375d]">
                            <x-icon name="trending-up" class="h-5 w-5" />
                            Temas populares
                        </h3>

                        @forelse ($temasPopulares as $tema)
                            <a href="{{ route('foro.show', $tema) }}" class="mb-3 block rounded-lg border border-gray-100 p-3 transition-colors last:mb-0 hover:bg-gray-50">
                                <p class="line-clamp-2 text-sm text-[#10375d]">{{ $tema->titulo }}</p>
                                <p class="mt-1 text-xs text-gray-500">{{ $tema->comentarios_count }} {{ $tema->comentarios_count === 1 ? 'respuesta' : 'respuestas' }}</p>
                            </a>
                        @empty
                            <p class="text-sm text-gray-500">Aún no hay temas.</p>
                        @endforelse
                    </div>

                    <div class="rounded-xl border border-[#869684]/50 bg-white p-6">
                        <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-[#10375d]">
                            <x-icon name="users" class="h-5 w-5" />
                            Top contribuidores
                        </h3>

                        @forelse ($topContribuidores as $puesto)
                            <div class="mb-3 flex items-center gap-3 last:mb-0">
                                <x-foro.avatar :usuario="$puesto['usuario']" size="h-8 w-8 text-xs" />
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm text-[#10375d]">{{ $puesto['usuario']->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $puesto['total'] }} {{ $puesto['total'] === 1 ? 'aporte' : 'aportes' }}</p>
                                </div>
                                <span class="text-xl">{{ ['🏆', '🥈', '🥉'][$loop->index] }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Aún no hay aportes.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ Ventana: nueva publicación ============ --}}
        @auth
            <div x-show="abierto" x-transition.opacity style="display: none"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" role="dialog" aria-modal="true">
                <div @click.outside="abierto = false" class="w-full max-w-xl rounded-xl bg-white p-6 shadow-xl">
                    <h2 class="text-lg font-semibold text-[#10375d]">Crear nueva publicación</h2>
                    <p class="text-sm text-gray-500">Comparte tu experiencia, haz una pregunta o da consejos a la comunidad</p>

                    <form method="POST" action="{{ route('foro.store') }}" class="mt-4 space-y-4">
                        @csrf

                        <div>
                            <label for="categoria" class="mb-1 block text-sm font-medium text-gray-700">Categoría</label>
                            <select id="categoria" name="categoria" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                                @foreach ($categorias as $clave => $etiqueta)
                                    <option value="{{ $clave }}" @selected(old('categoria', 'preguntas') === $clave)>{{ $etiqueta }}</option>
                                @endforeach
                            </select>
                            @error('categoria') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="titulo" class="mb-1 block text-sm font-medium text-gray-700">Título</label>
                            <input id="titulo" type="text" name="titulo" value="{{ old('titulo') }}" maxlength="150" placeholder="¿De qué quieres hablar?"
                                   class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                            @error('titulo') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="contenido" class="mb-1 block text-sm font-medium text-gray-700">Contenido</label>
                            <textarea id="contenido" name="contenido" rows="6" maxlength="5000" placeholder="Comparte tu historia, pregunta o consejo..."
                                      class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('contenido') }}</textarea>
                            @error('contenido') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="flex-1 rounded-md px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                                    style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%)">
                                Publicar
                            </button>
                            <button type="button" @click="abierto = false"
                                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endauth
    </section>

</x-app-layout>
