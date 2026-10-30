@props(['usuario', 'size' => 'h-12 w-12 text-sm'])

@php
    $iniciales = mb_strtoupper(
        collect(explode(' ', trim($usuario->name)))->filter()->map(fn ($parte) => mb_substr($parte, 0, 1))->take(2)->join('')
    );
@endphp

<div {{ $attributes->merge(['class' => 'flex shrink-0 items-center justify-center rounded-full font-semibold text-white ' . $size]) }}
     style="background: linear-gradient(135deg, #10375d 0%, #05647a 100%)">
    {{ $iniciales }}
</div>
