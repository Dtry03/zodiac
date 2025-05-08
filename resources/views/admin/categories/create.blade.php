@php
    $settings = app(App\Settings\AppearanceSettings::class);
    $bgColor = $settings->app_color ?? '#4f46e5';
@endphp
<style>
         
            :root {
                --theme-color: {{ $bgColor }};
         
                --theme-ring-color: {{ $bgColor }}40; 
            }

            input:focus,select:focus {
                border-color: var(--theme-color) !important; 
                box-shadow: 0 0 0 2px var(--theme-ring-color) !important;
   
            }

            option:hover{
                background-color: var(--theme-color)!important ;
            }
</style>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-400 leading-tight mx-auto text-center flex justify-center items-center h-20 pt-6">
                {{ __('Crear Categoría') }}
            </h2>
        </x-slot>

        {{-- Contenido principal --}}
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100 p-6 text-gray-400 bg-table-bg-color">

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

                        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf 

                            {{-- Campo Nombre --}}
                            <div>
                                <x-input-label for="name" :value="__('Nombre')" />
                                {{-- Usa old() para mantener el valor si falla la validación, o el valor actual de la categoría --}}
                                <x-text-input id="name" class="block mt-1 w-full  border-gray-400 bg-table-bg-color text-gray-400" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Campo Icono (Subida de Archivo) --}}
                            <div>
                                <x-input-label class="block mt-1 w-full  border-gray-400 bg-table-bg-color" for="icon" :value="__('Nuevo Icono (Opcional)')" />
                                <input id="icon" class="block w-full text-sm text-gray-400 border border-gray-300 rounded-lg cursor-pointer block mt-1 w-full  border-gray-400 bg-table-bg-color focus:outline-none  mt-1" type="file" name="icon" accept="image/*">
                                <p class="mt-1 text-sm text-gray-400 dark:text-gray-300" id="file_input_help">PNG, JPG, GIF, SVG (MAX. 2MB).</p>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            {{-- Campo Límite de Inscripciones --}}
                            <div>
                                <x-input-label for="max_user_signups_per_period" :value="__('Límite Inscripciones por Periodo (opcional)')" />
                                <x-text-input id="max_user_signups_per_period" class="block mt-1 w-full  border-gray-400 bg-table-bg-color text-gray-400" type="number" name="max_user_signups_per_period" :value="old('max_user_signups_per_period')" min="1" />
                                <p class="text-sm text-gray-400 dark:text-gray-400 mt-1">Dejar vacío si no hay límite.</p>
                                <x-input-error :messages="$errors->get('max_user_signups_per_period')" class="mt-2" />
                            </div>

                            {{-- Botones de Acción --}}
                            <div class="flex items-center gap-4 mt-6">
                                <x-primary-button style="background-color: {{ $bgColor }};">{{ __('Crear Categoría') }}</x-primary-button>

                                <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-400  hover:text-gray-300">
                                    {{ __('Cancelar') }}
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    
