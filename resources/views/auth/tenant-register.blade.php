{{-- Usamos el layout de invitado, ya que esta página es para usuarios no autenticados --}}
<x-guest-layout>
    {{-- Título del Formulario --}}
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-200">{{ __('Registra tu Gimnasio') }}</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Crea una cuenta para tu gimnasio y empieza a gestionar tus clases.') }}
        </p>
    </div>

    {{-- Mostrar errores de validación generales (si los hay) --}}
    @if ($errors->any())
        <div class="mb-4">
            <div class="font-medium text-red-600">{{ __('¡Ups! Algo salió mal.') }}</div>
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- El formulario enviará los datos a la ruta 'tenant.register.store' (que crearemos después) --}}
    <form method="POST" action="{{-- route('tenant.register.store') --}}"> {{-- La ruta se definirá más adelante --}}
        @csrf

        {{-- Sección: Datos del Gimnasio (Tenant) --}}
        <fieldset class="mb-6 border p-4 rounded-md">
            <legend class="text-lg font-medium text-gray-900 dark:text-gray-100 px-2">{{ __('Información del Gimnasio') }}</legend>

            <div class="mt-4">
                <x-input-label for="gym_name" :value="__('Nombre del Gimnasio')" />
                <x-text-input id="gym_name" class="block mt-1 w-full" type="text" name="gym_name" :value="old('gym_name')" required autofocus autocomplete="organization" />
                <x-input-error :messages="$errors->get('gym_name')" class="mt-2" />
            </div>


        </fieldset>

        {{-- Sección: Datos del Administrador Principal --}}
        <fieldset class="mb-6 border p-4 rounded-md">
            <legend class="text-lg font-medium text-gray-900 dark:text-gray-100 px-2">{{ __('Tu Cuenta de Administrador') }}</legend>

            <div class="mt-4">
                <x-input-label for="admin_name" :value="__('Tu Nombre')" />
                <x-text-input id="admin_name" class="block mt-1 w-full" type="text" name="admin_name" :value="old('admin_name')" required autocomplete="name" />
                <x-input-error :messages="$errors->get('admin_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="admin_last_name" :value="__('Tus Apellidos')" />
                <x-text-input id="admin_last_name" class="block mt-1 w-full" type="text" name="admin_last_name" :value="old('admin_last_name')" autocomplete="family-name" />
                <x-input-error :messages="$errors->get('admin_last_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="admin_email" :value="__('Tu Email')" />
                <x-text-input id="admin_email" class="block mt-1 w-full" type="email" name="admin_email" :value="old('admin_email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('admin_email')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="admin_password" :value="__('Contraseña')" />
                <x-text-input id="admin_password" class="block mt-1 w-full"
                                type="password"
                                name="admin_password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('admin_password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="admin_password_confirmation" :value="__('Confirmar Contraseña')" />
                <x-text-input id="admin_password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="admin_password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('admin_password_confirmation')" class="mt-2" />
            </div>
        </fieldset>

        <div class="flex items-center justify-end mt-6">
            {{-- Enlace a la página de login normal (si ya tienen cuenta de cliente) --}}
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta de cliente?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar Gimnasio y Continuar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
