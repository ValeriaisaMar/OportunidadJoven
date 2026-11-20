@props(['usuario', 'size' => 'h-12 w-12 text-sm'])

@php
    $iniciales = mb_strtoupper(
        collect(explode(' ', trim($usuario->name)))->filter()->map(fn ($parte) => mb_substr($parte, 0, 1))->take(2)->join('')
    );
@endphp

{{-- Avatar con iniciales, con el degradado azul-morado del diseño de Figma --}}
<div {{ $attributes->merge(['class' => 'flex shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-600 font-medium text-white ' . $size]) }}>
    {{ $iniciales }}
</div>
