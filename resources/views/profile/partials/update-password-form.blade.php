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
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-100 ">
            {{ __('Actualizar contraseña') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Asegúrese de que su cuenta utilice una contraseña larga y aleatoria para mantener su seguridad.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña actual')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full bg-table-bg-color border-gray-400 text-gray-400" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva contraseña')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full bg-table-bg-color border-gray-400 text-gray-400" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full bg-table-bg-color border-gray-400 text-gray-400" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button style="background-color: {{ $bgColor }};" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{{ __('Actualizar') }}</button class="">

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
