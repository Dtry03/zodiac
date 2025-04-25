{{-- Usa el componente de layout app.blade.php --}}
    <x-app-layout>
        {{-- Contenido para el slot 'header' --}}
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{-- Título dinámico con el nombre de la categoría --}}
                {{ __('Editar Categoría') }}: {{ $category->name }}
            </h2>
        </x-slot>

        {{-- Contenido principal --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                         {{-- Bloque para mostrar errores de validación (igual que en create) --}}
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                                <strong class="font-bold">¡Ups! Hubo algunos problemas:</strong>
                                <ul class="mt-2 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulario para editar categoría --}}
                        {{-- Envía a la ruta 'admin.categories.update' con el ID de la categoría --}}
                        {{-- Usa método POST, pero especifica PUT/PATCH con @method --}}
                        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf {{-- Token de seguridad --}}
                            @method('PUT') {{-- O @method('PATCH') - Especifica el método HTTP para actualizar --}}

                            {{-- Campo Nombre --}}
                            <div>
                                <x-input-label for="name" :value="__('Nombre')" />
                                {{-- Usa old() para mantener el valor si falla la validación, o el valor actual de la categoría --}}
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $category->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Campo Icono (Subida de Archivo) --}}
                            <div>
                                <x-input-label for="icon" :value="__('Nuevo Icono (Opcional)')" />
                                {{-- Muestra el icono actual si existe --}}
                                @if ($category->icon)
                                    <div class="mt-2 mb-2">
                                        <img src="{{ Storage::url($category->icon) }}" alt="Icono actual" class="h-16 w-16 object-cover rounded">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Icono actual. Sube uno nuevo para reemplazarlo.</p>
                                    </div>
                                @endif
                                <input id="icon" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1" type="file" name="icon" accept="image/*">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG, GIF, SVG (MAX. 2MB).</p>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            {{-- Campo Límite de Inscripciones --}}
                            <div>
                                <x-input-label for="max_user_signups_per_period" :value="__('Límite Inscripciones por Periodo (opcional)')" />
                                <x-text-input id="max_user_signups_per_period" class="block mt-1 w-full" type="number" name="max_user_signups_per_period" :value="old('max_user_signups_per_period', $category->max_user_signups_per_period)" min="1" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Dejar vacío si no hay límite.</p>
                                <x-input-error :messages="$errors->get('max_user_signups_per_period')" class="mt-2" />
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="flex items-center gap-4 mt-6">
                                <x-primary-button>{{ __('Actualizar Categoría') }}</x-primary-button>

                                <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    