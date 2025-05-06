<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Personalización de la Aplicación') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- Mensajes de sesión --}}
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
                     {{-- Bloque para mostrar errores de validación --}}
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

                    {{-- Formulario para actualizar configuración --}}
                    {{-- Envía a la ruta 'admin.settings.update' usando método PUT --}}
                    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Campo Logo --}}
                        <div>
                            <x-input-label for="app_logo" :value="__('Logotipo de la Aplicación')" />
                            {{-- Mostrar logo actual si existe --}}
                            {{-- Necesitaremos pasar $currentLogo desde el controlador --}}
                            {{-- @if(isset($currentLogo) && $currentLogo)
                                <div class="mt-2 mb-2">
                                    <img src="{{ Storage::url($currentLogo) }}" alt="Logo actual" class="h-16 object-contain">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Logo actual. Sube uno nuevo para reemplazarlo.</p>
                                </div>
                            @endif --}}
                             <input id="app_logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 mt-1" type="file" name="app_logo" accept="image/png, image/jpeg, image/svg+xml">
                             <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">PNG, JPG, SVG (Recomendado: SVG o PNG transparente).</p>
                             <x-input-error :messages="$errors->get('app_logo')" class="mt-2" />
                        </div>

                        {{-- Campo Color Principal --}}
                        <div>
                            <x-input-label for="app_color" :value="__('Color Principal')" />
                            {{-- Usamos un input de tipo color --}}
                            <input type="color" id="app_color" name="app_color"
                                   class="mt-1 block p-1 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                   {{-- Necesitaremos pasar $currentColor desde el controlador --}}
                                   value="{{ old('app_color', $currentColor ?? '#4f46e5') }}"> {{-- Valor por defecto Indigo --}}
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Selecciona el color principal para la interfaz.</p>
                            <x-input-error :messages="$errors->get('app_color')" class="mt-2" />
                        </div>


                        {{-- Botones de Acción --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Guardar Cambios') }}</x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
