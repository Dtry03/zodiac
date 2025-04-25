{{-- Usa el componente de layout app.blade.php --}}
    <x-app-layout>
        {{-- Contenido para el slot 'header' --}}
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Crear Nueva Categoría') }}
            </h2>
        </x-slot>

        {{-- Contenido principal --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        {{-- Formulario para crear categoría --}}
                     
                        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf {{-- Token de seguridad OBLIGATORIO para formularios POST --}}

                            {{-- Campo Nombre --}}
                            <div>
                                <x-input-label for="name" :value="__('Nombre')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                {{-- Muestra errores de validación para 'name' --}}
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Campo Icono (Subida de Archivo) --}}
                            <div>
                                {{-- Label actualizado --}}
                                <x-input-label for="icon" :value="__('Icono (Archivo de Imagen)')" />
                                {{-- Input cambiado a type="file" --}}
                                <input id="icon" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1" type="file" name="icon" accept="image/*">
                                {{-- Nota: accept="image/*" sugiere al navegador filtrar por imágenes --}}
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG, GIF, SVG (MAX. 2MB).</p> {{-- Ayuda opcional --}}
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            {{-- Campo Límite de Inscripciones --}}
                            <div>
                                <x-input-label for="max_user_signups_per_period" :value="__('Límite Inscripciones por Periodo (opcional)')" />
                                <x-text-input id="max_user_signups_per_period" class="block mt-1 w-full" type="number" name="max_user_signups_per_period" :value="old('max_user_signups_per_period')" min="1" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Dejar vacío si no hay límite.</p>
                                <x-input-error :messages="$errors->get('max_user_signups_per_period')" class="mt-2" />
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="flex items-center gap-4 mt-6">
                                <x-primary-button>{{ __('Guardar Categoría') }}</x-primary-button>

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
