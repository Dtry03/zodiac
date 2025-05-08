@php
    $settings = app(App\Settings\AppearanceSettings::class);
    $bgColor = $settings->app_color ?? '#4f46e5';
@endphp
<x-app-layout> {{-- O el layout que uses para clientes --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight mx-auto text-center flex justify-center items-center h-20 pt-6">
            {{-- Título mostrando el día efectivo --}}
            Clases para {{ $effectiveDayName }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-table-bg-color overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                     {{-- Mensajes de sesión (para éxito/error al apuntarse) --}}
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- Lista vertical de clases para hoy --}}
                    <ul class="space-y-4">
                        {{-- Iterar sobre las clases del día efectivo pasadas desde el controlador --}}
                        @forelse ($todaysClasses as $class)
                            @php
                                // Comprobaciones para el estado del botón
                                $isUserSignedUp = isset($userSignupIds[$class->id]);
                                // Contamos las inscripciones cargadas con Eager Loading
                                $currentSignupsCount = $class->signups->count();
                                $isClassFull = $currentSignupsCount >= $class->capacity;
                            @endphp
                            <li class="p-4 rounded-md shadow-sm border border-custom-dark-gray  flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                                {{-- Detalles de la clase --}}
                                <div class="flex-grow">
                                    <p class="font-semibold text-lg text-gray-400">
                                        {{ \Carbon\Carbon::parse($class->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($class->start_time)->addMinutes($class->duration_minutes)->format('H:i') }}
                                    </p>
                                    <p class="text-xl text-gray-400 dark:text-gray-200 font-medium">{{ $class->name }}</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-400">{{ $class->category->name ?? 'Sin categoría' }}</p>
                                    <p class="text-sm text-gray-400 dark:text-gray-400">Instructor: {{ $class->instructor->name ?? 'N/A' }}</p>
                                    {{-- Mostrar plazas disponibles/ocupadas --}}
                                    <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">
                                        Plazas: {{ $currentSignupsCount }} / {{ $class->capacity }}
                                    </p>
                                </div>
                                {{-- Botón/Formulario de Acción --}}
                                <div class="flex-shrink-0 w-full md:w-auto">
                                    @auth {{-- Asegurarse que el usuario está logueado --}}
                                        @if ($isUserSignedUp)
                                            {{-- Si ya está apuntado (lógica para anular vendrá después) --}}
                                            <span class="inline-flex items-center px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-md font-semibold text-xs uppercase tracking-widest">
                                                Ya estás apuntado
                                            </span>
                                            {{-- Aquí podría ir un botón/formulario para anular --}}
                                            {{-- <form action="{{ route('signups.destroy', $signup_id_correspondiente) }}" method="POST">...</form> --}}
                                        @elseif ($isClassFull)
                                            {{-- Si la clase está llena --}}
                                            <span class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md font-semibold text-xs uppercase tracking-widest">
                                                Clase Completa
                                            </span>
                                        @else
                                            {{-- Si hay plazas y no está apuntado: Mostrar botón para apuntarse --}}
                                            <form action="{{ route('inscripciones.store', $class) }}" method="POST">
                                                @csrf
                                                <button type="submit"  style="background-color: {{ $bgColor }};" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                                                    Apuntarse
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        {{-- Si el usuario no está logueado --}}
                                         <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                             Inicia sesión para apuntarte
                                        </a>
                                    @endauth
                                </div>
                            </li>
                        @empty
                            {{-- Mensaje si no hay clases hoy --}}
                            <li class="text-center py-8 text-gray-500 dark:text-gray-400">
                                No hay clases programadas para {{ $effectiveDayName }}.
                            </li>
                        @endforelse
                    </ul>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

