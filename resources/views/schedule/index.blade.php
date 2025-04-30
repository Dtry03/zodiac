<x-app-layout> {{-- O el layout que uses para clientes/público --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Horario Semanal de Clases') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Contenedor del Horario Semanal --}}
                    {{-- Grid de 1 columna en móvil, 7 en desktop --}}
                    <div class="grid grid-cols-1 md:grid-cols-7 gap-2 md:gap-4">

                        {{-- Iterar sobre los días (claves 1 a 7 del array $dayNames pasado desde el controlador) --}}
                        @foreach ($dayNames as $dayNumber => $dayName)
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 md:p-4 shadow mb-4 md:mb-0 min-h-[150px]">
                                {{-- Cabecera del día --}}
                                <h2 class="text-lg font-semibold text-center text-gray-700 dark:text-gray-200 mb-4 border-b pb-2 border-gray-200 dark:border-gray-600">
                                    {{ $dayName }}
                                </h2>

                                {{-- Lista de clases para este día --}}
                                <ul class="space-y-3">
                                    {{-- Verificar si hay clases para este día en el grupo --}}
                                    {{-- $classesGroupedByDay es el array agrupado pasado desde el controlador --}}
                                    {{-- $dayNumber es la clave actual (1 para Lunes, etc.) --}}
                                    @if (isset($classesGroupedByDay[$dayNumber]))
                                        {{-- Iterar sobre las clases de este día específico --}}
                                        @foreach ($classesGroupedByDay[$dayNumber] as $class)
                                            <li class="bg-white dark:bg-gray-800 p-3 rounded-md shadow-sm border border-gray-200 dark:border-gray-600">
                                                {{-- Hora Inicio - Fin --}}
                                                <p class="font-semibold text-sm text-indigo-700 dark:text-indigo-400">
                                                    {{-- Asegúrate que start_time y duration_minutes existen en el modelo $class --}}
                                                    {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->start_time)->addMinutes($class->duration_minutes)->format('H:i') }}
                                                </p>
                                                {{-- Nombre Clase --}}
                                                <p class="text-gray-800 dark:text-gray-200 font-medium text-base">{{ $class->name }}</p>
                                                {{-- Categoría (Usando la relación) --}}
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $class->category->name ?? '' }}</p>
                                                {{-- Instructor (Usando la relación) --}}
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $class->instructor ? 'con ' . $class->instructor->name : '' }}
                                                </p>
                                                {{-- NO hay botón de apuntarse --}}
                                            </li>
                                        @endforeach
                                    @else
                                        {{-- Mensaje si no hay clases para este día --}}
                                        <li class="text-xs text-center text-gray-400 dark:text-gray-500 mt-4">
                                            Sin clases programadas.
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endforeach

                    </div> {{-- Fin del grid del horario --}}

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
