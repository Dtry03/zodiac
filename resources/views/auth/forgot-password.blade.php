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
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Solo indícanos tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña y podrás elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full  border-gray-400 bg-table-bg-color text-gray-400" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button style="background-color: {{ $bgColor }};" class="ms-4 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">
                {{ __('Restablecer contraseña') }}
            </button>
        </div>
    </form>
</x-guest-layout>
