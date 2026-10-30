{{--
    Botones "me gusta" / "no me gusta" de una publicación o un comentario.
    Uso:  <x-foro.votos :item="$post" tipo="post" />
          <x-foro.votos :item="$comentario" tipo="comentario" />
--}}
@props(['item', 'tipo'])

@php
    // Solo está cargado el voto de la persona con sesión (si no hay sesión, no se consulta nada)
    $miVoto = $item->relationLoaded('votos') ? $item->votos->first()?->valor : null;
    $boton = 'inline-flex items-center gap-1 rounded-md px-2 py-1 text-sm transition-colors';
@endphp

@auth
    <form method="POST" action="{{ route('foro.votar', ['tipo' => $tipo, 'id' => $item->id]) }}" class="inline-flex items-center gap-1">
        @csrf

        <button type="submit" name="valor" value="1" title="Me gusta" aria-pressed="{{ $miVoto === 1 ? 'true' : 'false' }}"
                class="{{ $boton }} {{ $miVoto === 1 ? 'bg-[#05647a]/10 font-medium text-[#05647a]' : 'text-gray-500 hover:bg-gray-100 hover:text-[#05647a]' }}">
            <x-icon name="thumbs-up" class="h-4 w-4" />
            <span>{{ $item->likes_count }}</span>
        </button>

        <button type="submit" name="valor" value="-1" title="No me gusta" aria-pressed="{{ $miVoto === -1 ? 'true' : 'false' }}"
                class="{{ $boton }} {{ $miVoto === -1 ? 'bg-red-50 font-medium text-red-600' : 'text-gray-500 hover:bg-gray-100 hover:text-red-600' }}">
            <x-icon name="thumbs-down" class="h-4 w-4" />
            <span>{{ $item->dislikes_count }}</span>
        </button>
    </form>
@else
    <a href="{{ route('login') }}" title="Inicia sesión para votar" class="inline-flex items-center gap-3 text-sm text-gray-500 hover:text-[#05647a]">
        <span class="inline-flex items-center gap-1 px-2 py-1"><x-icon name="thumbs-up" class="h-4 w-4" /> {{ $item->likes_count }}</span>
        <span class="inline-flex items-center gap-1 px-2 py-1"><x-icon name="thumbs-down" class="h-4 w-4" /> {{ $item->dislikes_count }}</span>
    </a>
@endauth
