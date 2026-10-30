<x-app-layout>
    <section class="oj-section py-10">
        <div class="oj-container">

            @include('admin._menu')

            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-[#10375d]">Administrar cursos</h1>
                    <p class="text-sm text-gray-600">Publica solo cursos gratuitos de instituciones reconocidas.</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('cursos') }}" class="text-sm font-medium text-[#05647a] hover:underline">Ver en el sitio</a>
                    <a href="{{ route('admin.cursos.create') }}"
                       class="rounded-md bg-[#10375d] px-4 py-2 text-sm font-medium text-white hover:bg-[#05647a]">
                        + Nuevo curso
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-2 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="divide-y divide-gray-200 rounded-xl border border-gray-300 bg-white">
                @forelse ($cursos as $curso)
                    @php
                        $vencido = $curso->fecha_cierre && $curso->fecha_cierre->lt(today());
                    @endphp

                    <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                        <div class="min-w-0">
                            <p class="flex flex-wrap items-center gap-2 font-medium text-[#10375d]">
                                {{ $curso->titulo }}
                                <span class="rounded-md bg-gray-100 px-2 py-0.5 text-xs font-normal text-gray-600">{{ $curso->modalidad }}</span>
                                @if ($vencido)
                                    <span class="rounded-md bg-gray-200 px-2 py-0.5 text-xs font-normal text-gray-600">Vencido</span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-600">{{ $curso->institucion }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $curso->fecha_inicio ? 'Inicia el ' . $curso->fecha_inicio->format('d/m/Y') : 'Sin fecha de inicio' }}
                                ·
                                {{ $curso->fecha_cierre ? 'Cierra el ' . $curso->fecha_cierre->format('d/m/Y') : 'Sin fecha de cierre' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.cursos.edit', $curso) }}" class="text-sm font-medium text-[#05647a] hover:underline">Editar</a>

                            <form method="POST" action="{{ route('admin.cursos.destroy', $curso) }}"
                                  onsubmit="return confirm('¿Eliminar este curso?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-8 text-center text-sm text-gray-500">Todavía no hay cursos. Pulsa «Nuevo curso» para publicar el primero.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $cursos->links() }}</div>

        </div>
    </section>
</x-app-layout>
