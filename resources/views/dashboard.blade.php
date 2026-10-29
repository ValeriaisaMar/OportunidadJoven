@php
    $nombrePila = explode(' ', auth()->user()->name)[0];
    $empleosNuevos = \App\Models\Empleo::where('created_at', '>=', now()->subDays(7))->count();
    $oportunidades = \App\Models\Empleo::latest()->take(3)->get();
@endphp

<x-panel-layout :title="'Mi espacio | Oportunidad Joven'">

    <div class="grid lg:grid-cols-[1fr_320px] gap-8 mb-10">

        {{-- Bienvenida --}}
        <div>
            <p class="text-xs font-semibold tracking-wide text-[#05647a] mb-2">✦ TU PUNTO DE PARTIDA</p>
            <h1 class="text-3xl sm:text-4xl font-bold text-[#10375d] leading-tight mb-4">
                Hola, {{ $nombrePila }}. Tu próxima <span class="text-[#05647a]">oportunidad empieza aquí.</span>
            </h1>
            <p class="text-gray-600 max-w-xl mb-6">
                Encontramos nuevas opciones que encajan con tus intereses. Completá tu perfil para recibir recomendaciones aún más precisas.
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('empleos') }}" class="inline-flex items-center gap-2 rounded-md bg-[#10375d] text-white text-sm font-medium px-5 py-2.5 hover:bg-[#10375d]/90">
                    Explorar oportunidades
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
                <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-md border border-gray-300 text-sm font-medium px-5 py-2.5 text-[#10375d] hover:bg-gray-50">
                    Actualizar mi perfil
                </a>
            </div>
        </div>

        {{-- Progreso semanal (datos de ejemplo por ahora) --}}
        <div class="rounded-2xl p-6 text-white" style="background: linear-gradient(135deg, #10375d 0%, #05647a 100%)">
            <p class="text-xs font-medium text-white/70 mb-3">PROGRESO SEMANAL</p>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-3xl font-bold">3/5</p>
                    <p class="text-xs text-white/70">metas completadas</p>
                </div>
                <div class="h-14 w-14 rounded-full border-4 border-white/30 flex items-center justify-center text-xs font-semibold">
                    60%
                </div>
            </div>
            <div class="space-y-2 text-sm">
                <div class="flex items-center gap-2">
                    <span class="h-4 w-4 rounded bg-[#6db8bb] flex items-center justify-center">
                        <x-icon name="check" class="h-3 w-3 text-[#10375d]" />
                    </span>
                    <span class="line-through text-white/60">Guardar 3 vacantes</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-4 w-4 rounded border border-white/40"></span>
                    <span>Terminar tu biografía</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas rápidas --}}
    <div class="grid sm:grid-cols-3 gap-6 mb-10 pb-10 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <x-icon name="briefcase" class="h-5 w-5 text-[#05647a]" />
            <div>
                <p class="text-2xl font-bold text-[#10375d]">{{ $empleosNuevos }}</p>
                <p class="text-xs text-gray-500">Oportunidades nuevas</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <x-icon name="users" class="h-5 w-5 text-[#05647a]" />
            <div>
                <p class="text-2xl font-bold text-[#10375d]">04</p>
                <p class="text-xs text-gray-500">Postulaciones activas</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <x-icon name="clock" class="h-5 w-5 text-[#05647a]" />
            <div>
                <p class="text-2xl font-bold text-[#10375d]">08</p>
                <p class="text-xs text-gray-500">Horas de aprendizaje</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-[1fr_320px] gap-8">

        {{-- Oportunidades para ti --}}
        <div>
            <p class="text-xs font-semibold tracking-wide text-gray-400 mb-1">SELECCIÓN PERSONALIZADA</p>
            <h2 class="text-xl font-bold text-[#10375d] mb-4">Oportunidades para ti</h2>

            <div class="space-y-3">
                @forelse ($oportunidades as $empleo)
                    <div class="flex items-center gap-4 rounded-xl border border-gray-200 p-4 hover:shadow-sm transition-shadow">
                        <div class="h-10 w-10 rounded-md bg-[#10375d] text-white flex items-center justify-center text-xs font-semibold shrink-0">
                            {{ collect(explode(' ', $empleo->empresa))->map(fn($p) => mb_substr($p, 0, 1))->take(2)->join('') }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-400 uppercase">{{ $empleo->empresa }}</p>
                            <p class="font-medium text-[#10375d] truncate">{{ $empleo->titulo }}</p>
                            <p class="text-xs text-gray-500">{{ $empleo->ubicacion }} · {{ $empleo->jornada }} · {{ $empleo->created_at->diffForHumans() }}</p>
                        </div>
                        <button class="text-gray-300 hover:text-[#05647a]">
                            <x-icon name="bookmark" class="h-5 w-5" />
                        </button>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Todavía no hay empleos publicados.</p>
                @endforelse
            </div>

            <a href="{{ route('empleos') }}" class="inline-flex items-center gap-1 text-sm font-medium text-[#05647a] hover:underline mt-4">
                Ver todas las oportunidades
                <x-icon name="arrow-right" class="h-3.5 w-3.5" />
            </a>
        </div>

        {{-- Actividad (datos de ejemplo por ahora) --}}
        <div>
            <p class="text-xs font-semibold tracking-wide text-gray-400 mb-1">TU ACTIVIDAD</p>
            <h2 class="text-xl font-bold text-[#10375d] mb-4">Postulaciones</h2>

            <div class="space-y-4 border-l border-gray-200 pl-4 mb-6">
                <div>
                    <p class="text-xs text-gray-400">LUN 12</p>
                    <p class="text-sm font-medium text-[#10375d]">Vita Studio</p>
                    <p class="text-xs text-gray-500">CV recibido</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">JUE 08</p>
                    <p class="text-sm font-medium text-[#10375d]">Grupo Nova</p>
                    <p class="text-xs text-gray-500">En revisión</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400">MAR 06</p>
                    <p class="text-sm font-medium text-[#10375d]">Colectivo Río</p>
                    <p class="text-xs text-gray-500">Postulación enviada</p>
                </div>
            </div>

            <div class="rounded-xl bg-gray-50 p-4">
                <p class="text-xs font-semibold tracking-wide text-gray-400 mb-2">CURSO RECOMENDADO</p>
                <p class="font-medium text-[#10375d] mb-1">Tu primer CV: de cero a entrevista</p>
                <p class="text-xs text-gray-500 mb-3">Aprendé a contar tu potencial aunque todavía no tengas experiencia.</p>
                <a href="{{ route('cursos') }}" class="text-sm font-medium text-[#05647a] hover:underline">Empezar →</a>
            </div>
        </div>
    </div>

    {{-- Banner de comunidad --}}
    <div class="rounded-2xl mt-10 p-8 text-white" style="background: linear-gradient(90deg, #10375d 0%, #05647a 100%)">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <p class="text-xs font-medium text-white/70 mb-2">○ COMUNIDAD OPORTUNIDADJOVEN</p>
                <h3 class="text-2xl font-bold mb-2">No tenés que saberlo todo para dar el primer paso.</h3>
                <p class="text-white/80 max-w-xl">
                    Conversá con jóvenes que también están buscando su primera experiencia y compartí preguntas, logros y aprendizajes.
                </p>
            </div>
            <a href="{{ route('foro') }}" class="shrink-0 inline-flex items-center gap-2 rounded-md bg-white/10 border border-white/30 text-sm font-medium px-5 py-2.5 hover:bg-white/20">
                Ir a la comunidad
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    </div>

</x-panel-layout>