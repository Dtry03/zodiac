<x-app-layout> {{-- O el layout que uses para clientes/público --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight mx-auto text-center flex justify-center items-center h-20 pt-6">
            {{ __('Horario Semanal de Clases') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-table-bg-color overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Contenedor del Horario Semanal --}}
                    {{-- Grid de 1 columna en móvil, 7 en desktop --}}
                    <div class="grid grid-cols-1 md:grid-cols-7 gap-2 md:gap-4">

                        {{-- Iterar sobre los días (claves 1 a 7 del array $dayNames pasado desde el controlador) --}}
                        @foreach ($dayNames as $dayNumber => $dayName)
                            <div class="rounded-lg p-3 md:p-4  shadow mb-4 border border-custom-dark-gray  md:mb-0 min-h-[150px]">
                                {{-- Cabecera del día --}}
                                <h2 class="text-lg font-semibold text-center text-gray-400 mb-4 border-b pb-2 border-custom-dark-gray">
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
                                            <li class="p-3 rounded-md shadow-sm">
                                                {{-- Hora Inicio - Fin --}}
                                                <p class="font-semibold text-sm text-gray-400 ">
                                                    {{-- Asegúrate que start_time y duration_minutes existen en el modelo $class --}}
                                                    {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->start_time)->addMinutes($class->duration_minutes)->format('H:i') }}
                                                </p>
                                                {{-- Nombre Clase --}}
                                                <p class="text-gray-400 font-medium text-base">{{ $class->name }}</p>
                                                {{-- Categoría (Usando la relación) --}}
                                                <p class="text-xs text-gray-400">{{ $class->category->name ?? '' }}</p>
                                                {{-- Instructor (Usando la relación) --}}
                                                <p class="text-xs text-gray-400">
                                                    {{ $class->instructor ? 'con ' . $class->instructor->name : '' }}
                                                </p>
                                                {{-- NO hay botón de apuntarse --}}
                                            </li>
                                        @endforeach
                                    @else
                                        {{-- Mensaje si no hay clases para este día --}}
                                        <li class="text-xs text-center text-gray-400 mt-4">
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
