<x-app-layout>
    <section class="oj-section py-10">
        <div class="oj-container">

            @include('admin._menu')

            <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-[#10375d]">Administrar pasantías</h1>
                    <p class="text-sm text-gray-600">Publica pasantías y programas trainee reales.</p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('pasantias') }}" class="text-sm font-medium text-[#05647a] hover:underline">Ver en el sitio</a>
                    <a href="{{ route('admin.pasantias.create') }}"
                       class="rounded-md bg-[#10375d] px-4 py-2 text-sm font-medium text-white hover:bg-[#05647a]">
                        + Nueva pasantía
                    </a>
                </div>
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-2 text-sm text-green-700">
                    {{ session('status') }}
                </div>
            @endif

            <div class="divide-y divide-gray-200 rounded-xl border border-gray-300 bg-white">
                @forelse ($pasantias as $pasantia)
                    @php
                        $vencida = $pasantia->fecha_cierre && $pasantia->fecha_cierre->lt(today());
                    @endphp

                    <div class="flex flex-wrap items-center justify-between gap-3 p-4">
                        <div class="min-w-0">
                            <p class="flex flex-wrap items-center gap-2 font-medium text-[#10375d]">
                                {{ $pasantia->titulo }}
                                <span class="rounded-md bg-gray-100 px-2 py-0.5 text-xs font-normal text-gray-600">{{ $pasantia->tipo }}</span>
                                @if ($vencida)
                                    <span class="rounded-md bg-gray-200 px-2 py-0.5 text-xs font-normal text-gray-600">Vencida</span>
                                @endif
                            </p>
                            <p class="text-sm text-gray-600">{{ $pasantia->empresa }} · {{ $pasantia->ubicacion }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $pasantia->fecha_cierre ? 'Cierra el ' . $pasantia->fecha_cierre->format('d/m/Y') : 'Sin fecha de cierre' }}
                            </p>
                        </div>

                        <div class="flex items-center gap-4">
                            <a href="{{ route('admin.pasantias.edit', $pasantia) }}" class="text-sm font-medium text-[#05647a] hover:underline">Editar</a>

                            <form method="POST" action="{{ route('admin.pasantias.destroy', $pasantia) }}"
                                  onsubmit="return confirm('¿Eliminar esta pasantía?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm font-medium text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="p-8 text-center text-sm text-gray-500">Todavía no hay pasantías. Pulsa «Nueva pasantía» para publicar la primera.</p>
                @endforelse
            </div>

            <div class="mt-6">{{ $pasantias->links() }}</div>

        </div>
    </section>
</x-app-layout>
