<x-app-layout>

    <section class="oj-section py-10">
        <div class="oj-container">

            <div class="mb-8">
                <h1 class="text-3xl font-bold text-[#10375d] mb-2">Búsqueda de Empleos</h1>
                <p class="text-gray-600">Encuentra el trabajo ideal para comenzar tu carrera</p>
            </div>

            {{-- Buscador y filtros --}}
            <form method="GET" action="{{ route('empleos') }}" class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="grid md:grid-cols-4 gap-4 mb-4">
                    <div class="md:col-span-2">
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            placeholder="Buscar por título, empresa..."
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#6db8bb]"
                        >
                    </div>

                    <select name="ubicacion" class="rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="Todas las ubicaciones">Todas las ubicaciones</option>
                        @foreach ($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion }}" @selected(request('ubicacion') === $ubicacion)>
                                {{ $ubicacion }}
                            </option>
                        @endforeach
                    </select>

                    <select name="jornada" class="rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="Todos los tipos">Todos los tipos</option>
                        @foreach ($jornadas as $jornada)
                            <option value="{{ $jornada }}" @selected(request('jornada') === $jornada)>
                                {{ $jornada }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="inline-flex items-center gap-2 rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-[#10375d] hover:bg-gray-50">
                        Buscar
                    </button>
                    <p class="text-sm text-gray-600">{{ $empleos->total() }} empleos encontrados</p>
                </div>
            </form>

            {{-- Listado de empleos --}}
            <div class="space-y-4">
                @forelse ($empleos as $empleo)
                    <div class="bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow p-6">

                        <div class="flex items-start justify-between mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="rounded-md bg-blue-100 text-blue-700 px-2 py-0.5 text-xs font-medium">{{ $empleo->experiencia }}</span>
                                    <span class="rounded-md border border-gray-300 px-2 py-0.5 text-xs font-medium text-gray-600">{{ $empleo->jornada }}</span>
                                    <span class="text-xs text-gray-500 ml-auto">{{ $empleo->created_at->diffForHumans() }}</span>
                                </div>
                                <h2 class="text-xl font-semibold text-[#10375d] mb-1">{{ $empleo->titulo }}</h2>
                                <p class="text-gray-600">{{ $empleo->empresa }}</p>
                            </div>
                        </div>

                        <p class="text-sm text-gray-600 my-4">{{ $empleo->descripcion }}</p>

                        <div class="grid sm:grid-cols-2 gap-3 mb-4 text-sm text-gray-600">
                            <div>📍 {{ $empleo->ubicacion }} · {{ $empleo->modalidad }}</div>
                            <div>💰 {{ $empleo->salario ?? 'A convenir' }}</div>

                            @auth
                                @if ($empleo->contacto)
                                    <div class="sm:col-span-2">✉️ Contacto: {{ $empleo->contacto }}</div>
                                @endif
                            @endauth

                            @if ($empleo->fecha_cierre)
                                <div class="sm:col-span-2">⏳ Cierra el {{ $empleo->fecha_cierre->format('d/m/Y') }}</div>
                            @endif
                        </div>

                        @if ($empleo->requisitos)
                            <div class="mb-4">
                                <p class="text-sm text-gray-700 mb-2">Requisitos:</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($empleo->requisitos as $requisito)
                                        <span class="rounded-md bg-gray-100 px-2 py-0.5 text-xs text-gray-600">{{ $requisito }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex gap-3">
                            @auth
                                @if ($empleo->url_postulacion)
                                    <a href="{{ $empleo->url_postulacion }}" target="_blank" rel="noopener noreferrer"
                                       class="flex-1 rounded-md bg-[#10375d] py-2 text-center text-sm font-medium text-white hover:bg-[#05647a]">
                                        Ir a la convocatoria
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 rounded-md bg-[#10375d] py-2 text-center text-sm font-medium text-white hover:bg-[#05647a]">
                                    Ingresa para aplicar
                                </a>
                            @endauth

                            <button class="rounded-md border border-gray-300 text-sm font-medium px-4 py-2 text-[#10375d] hover:bg-gray-50">
                                Ver detalles
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-12">Todavía no hay empleos publicados.</p>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $empleos->links() }}
            </div>

        </div>
    </section>

</x-app-layout>