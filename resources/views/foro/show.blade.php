<x-app-layout>

    @php
        $usuario = auth()->user();
        $puedeBorrarPost = $usuario && ($usuario->id === $post->user_id || $usuario->esAdmin());
    @endphp

    <section class="oj-section py-10">
        <div class="oj-container">
            <div class="mx-auto max-w-4xl">

                <a href="{{ route('foro') }}" class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-[#05647a] hover:underline">
                    <x-icon name="arrow-left" class="h-4 w-4" />
                    Volver al foro
                </a>

                @if (session('status'))
                    <div class="mb-6 rounded-md bg-green-100 px-4 py-2 text-sm text-green-700">{{ session('status') }}</div>
                @endif

                {{-- ============ La publicación ============ --}}
                <article id="post-{{ $post->id }}" class="rounded-xl border border-[#869684]/50 bg-white p-6 sm:p-8">
                    <div class="mb-3"><x-foro.categoria :categoria="$post->categoria" /></div>

                    <h1 class="mb-4 break-words text-2xl font-bold text-[#10375d]">{{ $post->titulo }}</h1>

                    <div class="mb-6 flex items-center gap-3">
                        <x-foro.avatar :usuario="$post->autor" size="h-10 w-10 text-sm" />
                        <div class="text-sm">
                            <p class="font-medium text-[#10375d]">{{ $post->autor->name }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $post->autor->esAdmin() ? 'Administrador' : 'Miembro' }} • {{ $post->created_at->locale('es')->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="whitespace-pre-line break-words text-gray-700">{{ $post->contenido }}</div>

                    <div class="mt-6 flex flex-wrap items-center gap-4 border-t border-gray-100 pt-4 text-sm text-gray-500">
                        <x-foro.votos :item="$post" tipo="post" />

                        <span class="inline-flex items-center gap-1">
                            <x-icon name="message-circle" class="h-4 w-4" />
                            {{ $post->comentarios_count }}
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <x-icon name="eye" class="h-4 w-4" />
                            {{ $post->vistas }}
                        </span>

                        @if ($puedeBorrarPost)
                            <form method="POST" action="{{ route('foro.destroy', $post) }}" class="ml-auto"
                                  onsubmit="return confirm('¿Eliminar esta publicación y todos sus comentarios?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:underline">
                                    <x-icon name="trash-2" class="h-4 w-4" />
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </article>

                {{-- ============ Comentarios ============ --}}
                <div id="comentarios" class="mt-8">
                    <h2 class="mb-4 text-lg font-semibold text-[#10375d]">
                        {{ $post->comentarios_count }} {{ $post->comentarios_count === 1 ? 'comentario' : 'comentarios' }}
                    </h2>

                    @auth
                        <form method="POST" action="{{ route('foro.comentar', $post) }}" class="mb-6 rounded-xl border border-[#869684]/50 bg-white p-4">
                            @csrf
                            <label for="contenido" class="sr-only">Escribe un comentario</label>
                            <textarea id="contenido" name="contenido" rows="3" maxlength="2000" placeholder="Escribe un comentario..."
                                      class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('contenido') }}</textarea>
                            @error('contenido') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror

                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-md px-4 py-2 text-sm font-medium text-white hover:opacity-90"
                                        style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%)">
                                    <x-icon name="send" class="h-4 w-4" />
                                    Comentar
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-6 rounded-xl border border-dashed border-[#869684] bg-white p-4 text-center text-sm text-gray-600">
                            <a href="{{ route('login') }}" class="font-medium text-[#05647a] hover:underline">Inicia sesión</a>
                            o
                            <a href="{{ route('register') }}" class="font-medium text-[#05647a] hover:underline">regístrate</a>
                            para comentar y votar.
                        </div>
                    @endauth

                    <div class="space-y-4">
                        @forelse ($comentarios as $comentario)
                            @php
                                $puedeBorrar = $usuario && ($usuario->id === $comentario->user_id || $usuario->esAdmin());
                            @endphp

                            <div id="comentario-{{ $comentario->id }}" class="flex gap-3 rounded-xl border border-[#869684]/50 bg-white p-4">
                                <x-foro.avatar :usuario="$comentario->autor" size="h-9 w-9 text-xs" />

                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-x-2 text-xs text-gray-500">
                                        <span class="text-sm font-medium text-[#10375d]">{{ $comentario->autor->name }}</span>
                                        <span>{{ $comentario->autor->esAdmin() ? 'Administrador' : 'Miembro' }}</span>
                                        <span>•</span>
                                        <span>{{ $comentario->created_at->locale('es')->diffForHumans() }}</span>
                                    </div>

                                    <p class="mt-1 whitespace-pre-line break-words text-sm text-gray-700">{{ $comentario->contenido }}</p>

                                    <div class="mt-2 flex items-center gap-4 text-sm text-gray-500">
                                        <x-foro.votos :item="$comentario" tipo="comentario" />

                                        @if ($puedeBorrar)
                                            <form method="POST" action="{{ route('foro.comentarios.destroy', $comentario) }}" class="ml-auto"
                                                  onsubmit="return confirm('¿Eliminar este comentario?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 text-xs text-red-600 hover:underline">
                                                    <x-icon name="trash-2" class="h-3.5 w-3.5" />
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="rounded-xl border border-dashed border-[#869684] bg-white p-6 text-center text-sm text-gray-500">
                                Todavía no hay comentarios. ¡Sé la primera persona en responder!
                            </p>
                        @endforelse
                    </div>

                    <div class="mt-6">{{ $comentarios->links() }}</div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
