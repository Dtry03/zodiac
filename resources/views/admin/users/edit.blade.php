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
            {{ __('Editar Usuario') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-400 bg-table-bg-color">

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

                    {{-- Formulario para editar usuario --}}
                    {{-- Envía a la ruta 'admin.users.update' con el ID del usuario --}}
                    {{-- Usa método POST, pero especifica PUT/PATCH con @method --}}
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- O PATCH --}}

                        {{-- Campo Nombre --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" class="block mt-1 w-full  border-gray-400 bg-table-bg-color" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Campo Apellidos --}}
                        <div>
                            <x-input-label for="last_name" :value="__('Apellidos')" />
                            <x-text-input id="last_name" class="block mt-1 w-full  border-gray-400 bg-table-bg-color" type="text" name="last_name" :value="old('last_name', $user->last_name)" />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        {{-- Campo Email (Quizás hacerlo readonly si no quieres que el admin lo cambie) --}}
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full  border-gray-400 bg-table-bg-color bg-gray-100 dark:bg-gray-700" type="email" name="email" :value="old('email', $user->email)" required readonly />
                            <p class="mt-1 text-xs text-gray-400">El email no se puede modificar.</p>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Campo Username (Quizás hacerlo readonly) --}}
                         <div>
                            <x-input-label for="username" :value="__('Nombre de Usuario')" />
                            <x-text-input id="username" class="block mt-1 w-full  border-gray-400 bg-table-bg-color bg-gray-100 dark:bg-gray-700" type="text" name="username" :value="old('username', $user->username)" readonly />
                             <p class="mt-1 text-xs text-gray-400">El nombre de usuario no se puede modificar.</p>
                            <x-input-error :messages="$errors->get('username')" class="mt-2" />
                        </div>

                        {{-- Campo Rol (Select) --}}
                        <div>
                            <x-input-label for="role" :value="__('Rol')" />
                            <select name="role" id="role" required class="block mt-1 w-full  border-gray-400 bg-table-bg-color border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                {{-- Iterar sobre los roles pasados desde el controlador --}}
                                @foreach ($roles as $roleValue)
                                    <option value="{{ $roleValue }}" {{ old('role', $user->role) == $roleValue ? 'selected' : '' }}>
                                        {{ ucfirst($roleValue) }} {{-- Muestra el rol con la primera letra en mayúscula --}}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        {{-- Campo Contraseña (Opcional: permitir al admin resetearla) --}}
                        {{-- Por simplicidad, no incluimos cambio de contraseña aquí --}}
                        {{-- Si se necesitara, habría que añadir dos campos (password y password_confirmation) --}}
                        {{-- y lógica especial en el controlador para hashear y actualizar SOLO si se proporciona una nueva. --}}


                        {{-- Botones de Acción --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button style="background-color: {{ $bgColor }};">{{ __('Actualizar Usuario') }}</x-primary-button>

                            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400  hover:text-gray-300">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
