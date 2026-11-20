{{-- Paginación con el estilo del diseño de Figma (botones outline pequeños, página actual en azul) --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Paginación" class="flex flex-wrap items-center justify-center gap-2">
        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="oj-btn-outline oj-btn-sm pointer-events-none opacity-50">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="oj-btn-outline oj-btn-sm">Anterior</a>
        @endif

        {{-- Números --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-1 text-sm text-gray-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="oj-btn oj-btn-sm border border-oj-primary bg-oj-primary text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="oj-btn-outline oj-btn-sm" aria-label="Ir a la página {{ $page }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="oj-btn-outline oj-btn-sm">Siguiente</a>
        @else
            <span class="oj-btn-outline oj-btn-sm pointer-events-none opacity-50">Siguiente</span>
        @endif
    </nav>
@endif
