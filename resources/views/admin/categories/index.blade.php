@php
    $settings = app(App\Settings\AppearanceSettings::class);
    $bgColor = $settings->app_color ?? '#4f46e5';
@endphp
<x-app-layout>
  
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-400 leading-tight mx-auto text-center flex justify-center items-center h-20 pt-6">
            {{ __('Gestionar Categorías') }}
        </h2>
    </x-slot>

    {{-- Contenido principal (se insertará en {{ $slot }} del layout) --}}
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100"> {{-- Ajustado para tema oscuro si aplica --}}

                    {{-- Botón para ir al formulario de creación (ruta en inglés) --}}
                    <div class="mb-4">
                        <a href="{{ route('admin.categories.create') }}" style="background-color: {{ $bgColor }};" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                            Crear Nueva Categoría
                        </a>
                    </div>

                    {{-- Tabla para mostrar las categorías --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-custom-dark-gray bg-table-bg-color">
                            <thead>
                                <tr>
                                    {{-- Nombres de columna (UI en español) --}}
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Icono
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                        Límite Inscripciones
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Acciones</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-custom-dark-gray">
                                {{-- Iterar sobre la variable $categories --}}
                                @forelse ($categories as $category) {{-- Variable $categories, item $category --}}
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $category->name }} {{-- Propiedad 'name' del modelo Category --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $category->icon ?? '-' }} {{-- Propiedad 'icon' --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                            {{ $category->max_user_signups_per_period ?? 'Sin límite' }} {{-- Propiedad --}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            {{-- Enlace para editar (ruta y variable en inglés) --}}
                                            <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-500 dark:hover:text-indigo-300">Editar</a>

                                            {{-- Formulario para eliminar (ruta y variable en inglés) --}}
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta categoría? ¡No podrás borrarla si tiene clases asociadas!');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-500">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Mensaje si no hay categorías --}}
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No hay categorías creadas todavía.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
