<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Título mostrando el nombre de la clase --}}
            Inscritos a: {{ $gymClass->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Detalles de la Clase --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-2">Detalles de la Clase</h3>
                    @php
                        $dayNames = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
                    @endphp
                    <p><strong>Día:</strong> {{ $dayNames[$gymClass->day_of_week] ?? 'N/D' }}</p>
                    <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($gymClass->start_time)->format('H:i') }} ({{ $gymClass->duration_minutes }} min)</p>
                    <p><strong>Categoría:</strong> {{ $gymClass->category->name ?? 'N/A' }}</p>
                    <p><strong>Instructor:</strong> {{ $gymClass->instructor->name ?? 'Sin asignar' }}</p>
                    <p><strong>Capacidad:</strong> {{ $signups->count() }} / {{ $gymClass->capacity }}</p>
                </div>
            </div>

            {{-- Tabla de Inscritos --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Lista de Inscritos</h3>

                    {{-- Mensajes de sesión (para éxito/error al eliminar inscripción) --}}
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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre Usuario</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    {{-- <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha Inscripción</th> --}}
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                {{-- Iterar sobre las inscripciones ($signups) pasadas desde el controlador --}}
                                @forelse ($signups as $signup)
                                    {{-- Acceder al usuario a través de la relación cargada --}}
                                    @if($signup->user) {{-- Comprobar si el usuario existe --}}
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $signup->user->name }} {{ $signup->user->last_name ?? '' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $signup->user->email }}
                                            </td>
                                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                {{ $signup->created_at ? \Carbon\Carbon::parse($signup->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                            </td> --}}
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- Formulario para eliminar esta inscripción específica --}}
                                                {{-- Apunta a la misma ruta/controlador que usa el cliente para anular --}}
                                                <form action="{{ route('inscripciones.destroy', $signup->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar la inscripción de este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Eliminar Inscripción</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @else
                                        {{-- Caso raro: inscripción sin usuario válido --}}
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm text-red-500">
                                                Error: Usuario asociado a esta inscripción no encontrado (ID: {{ $signup->id_user }}).
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                {{-- Permitir borrar la inscripción huérfana --}}
                                                <form action="{{ route('inscripciones.destroy', $signup->id) }}" method="POST" onsubmit="return confirm('Eliminar inscripción huérfana (usuario no encontrado)?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No hay usuarios inscritos en esta clase todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Botón para volver a la lista de clases --}}
                    <div class="mt-6">
                         <a href="{{ route('admin.gym_classes.index') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                            &larr; Volver a la lista de clases
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
