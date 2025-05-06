<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Título mostrando la fecha efectiva --}}
            Listas de Inscritos para el {{ $effectiveDayName }}, {{ $effectiveDate->isoFormat('D [de] MMMM [de]<x_bin_398>') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Botón General para PDF (Funcional) --}}
            <div class="mb-6 text-right">
                <a href="{{ route('admin.reports.daily_signups.pdf') }}" target="_blank"
                   class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Descargar PDF (Todas las Listas)
                </a>
            </div>

            {{-- Iterar sobre las clases del día efectivo --}}
            @forelse ($todaysClasses as $class)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700">
                        {{-- Encabezado de la Clase --}}
                        <div class="flex flex-col md:flex-row justify-between md:items-center mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-400">{{ $class->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->start_time)->addMinutes($class->duration_minutes)->format('H:i') }}
                                    | Instructor: {{ $class->instructor->name ?? 'N/A' }}
                                    | Capacidad: {{ $class->signups->count() }} / {{ $class->capacity }}
                                </p>
                            </div>
                            {{-- Botón PDF para esta clase (Funcional) --}}
                            <div class="mt-3 md:mt-0">
                                 <a href="{{ route('admin.gym_classes.signups.pdf', $class->id) }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1.5 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    PDF Lista
                                 </a>
                            </div>
                        </div>
                    </div>

                    {{-- Lista/Tabla de Inscritos para esta clase --}}
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        @if($class->signups->count() > 0)
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                {{-- Iterar sobre las inscripciones de esta clase --}}
                                @foreach ($class->signups as $signup)
                                    @if($signup->user) {{-- Comprobar si el usuario existe --}}
                                        <li class="py-3 flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                                            {{-- Datos del usuario --}}
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $signup->user->name }} {{ $signup->user->last_name ?? '' }}</p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $signup->user->email }}</p>
                                            </div>
                                            {{-- Botón para eliminar inscripción (Admin) --}}
                                            <div class="flex-shrink-0 mt-2 sm:mt-0">
                                                <form action="{{ route('inscripciones.destroy', $signup->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la inscripción de este usuario [{{ $signup->user->name }}]?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @else
                                         {{-- Caso raro: inscripción sin usuario válido --}}
                                        <li class="py-3 flex justify-between items-center">
                                            <span class="text-sm text-red-500">Error: Usuario asociado (ID: {{ $signup->id_user }}) no encontrado.</span>
                                            <form action="{{ route('inscripciones.destroy', $signup->id) }}" method="POST" onsubmit="return confirm('Eliminar inscripción huérfana (usuario no encontrado)?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No hay nadie inscrito en esta clase todavía.</p>
                        @endif
                    </div>
                </div>
            @empty
                {{-- Mensaje si no hay clases programadas para el día efectivo --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                        No hay clases programadas para {{ $effectiveDayName }}.
                    </div>
                </div>
            @endforelse

             {{-- Botón para volver a alguna parte (opcional) --}}
             <div class="mt-6">
                 <a href="{{ route('dashboard') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                    &larr; Volver al Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
