@props(['active' => false])

@php
// Clases base SIN color de texto específico
$baseClasses = 'inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out focus:outline-none'; // Quitado text-gray-500 dark:text-gray-400

// Clases para estado activo (pueden mantener su color específico o intentar heredar)
$activeClasses = 'border-indigo-400 dark:border-indigo-600 focus:border-indigo-700 dark:focus:border-indigo-300'; // Quitado text-gray-900 dark:text-gray-100 si quieres que herede
// Clases para estado inactivo (quitar colores hover/focus de texto)
$inactiveClasses = 'border-transparent hover:border-gray-300 dark:hover:border-gray-700 focus:border-gray-300 dark:focus:border-gray-700'; // Quitado hover:text... focus:text...

$classes = $baseClasses . ' ' . ($active ? $activeClasses : $inactiveClasses);
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>