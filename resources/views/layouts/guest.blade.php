<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- Obtener los settings de apariencia --}}
        @php
            // Asegúrate que el namespace sea el correcto donde creaste AppearanceSettings
            try {
                if (class_exists(App\Settings\AppearanceSettings::class)) {
                    $settings = app(App\Settings\AppearanceSettings::class);
                    $appLogo = $settings->app_logo ?? null;
                    // El color temático no se usará directamente aquí, pero podrías si quisieras
                    // $appColor = $settings->app_color ?? '#4f46e5';
                } else {
                    $settings = null;
                    $appLogo = null;
                    // $appColor = '#4f46e5';
                }
            } catch (\Exception $e) {
                $settings = null;
                $appLogo = null;
                // $appColor = '#4f46e5';
                // \Log::error('Error al cargar AppearanceSettings en guest layout: ' . $e->getMessage());
            }
        @endphp
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-custom-dark-gray">
            <div>
                <a href="/">
                     <img src="{{ Storage::url($appLogo) }}" alt="{{ config('app.name', 'Laravel') }} Logo" class="w-48 h-48 fill-current text-gray-500">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-table-bg-color shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
