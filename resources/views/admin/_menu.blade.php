<div class="mb-6 flex flex-wrap gap-2">
    @foreach ([
        'admin.empleos.index' => ['Empleos', 'admin.empleos.*'],
        'admin.pasantias.index' => ['Pasantías', 'admin.pasantias.*'],
        'admin.cursos.index' => ['Cursos', 'admin.cursos.*'],
    ] as $ruta => [$titulo, $patron])
        <a href="{{ route($ruta) }}"
           class="rounded-md px-4 py-2 text-sm font-medium {{ request()->routeIs($patron) ? 'bg-[#10375d] text-white' : 'border border-gray-300 bg-white text-[#10375d] hover:bg-gray-50' }}">
            {{ $titulo }}
        </a>
    @endforeach
</div>
