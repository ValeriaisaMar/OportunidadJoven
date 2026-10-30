@props(['categoria'])

@php
    // Los colores viven aquí (y no en el modelo) para que Tailwind los detecte al compilar
    $colores = [
        'experiencias' => 'bg-purple-100 text-purple-700',
        'preguntas' => 'bg-blue-100 text-blue-700',
        'consejos' => 'bg-green-100 text-green-700',
        'entrevistas' => 'bg-orange-100 text-orange-700',
    ];
    $etiqueta = \App\Models\ForoPost::CATEGORIAS[$categoria] ?? ucfirst($categoria);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium ' . ($colores[$categoria] ?? 'bg-gray-100 text-gray-700')]) }}>
    {{ $etiqueta }}
</span>
