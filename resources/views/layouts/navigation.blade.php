@php
    // Asegúrate que el namespace sea el correcto
    try {
        // Intenta obtener los settings. Si la clase o la tabla no existen (ej. durante la instalación inicial), usa valores por defecto.
        if (class_exists(App\Settings\AppearanceSettings::class)) {
            $settings = app(App\Settings\AppearanceSettings::class);
            $bgColor = $settings->app_color ?? '#4f46e5'; // Color de fondo
            $appLogo = $settings->app_logo ?? null;
        } else {
            $settings = null;
            $bgColor = '#4f46e5'; // Indigo por defecto
            $appLogo = null;
        }
    } catch (\Exception $e) {
        // En caso de cualquier otro error al obtener settings (ej. tabla no migrada)
        $settings = null;
        $bgColor = '#4f46e5';
        $appLogo = null;
        // \Log::error('Error al cargar AppearanceSettings: ' . $e->getMessage()); // Opcional: registrar el error
    }

    // --- Lógica para determinar el color del texto ---
    $hex = ltrim($bgColor, '#');
    if (strlen($hex) == 3) { $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2]; }
    if (strlen($hex) !== 6) { $hex = '4f46e5'; } // Fallback si el hex no es válido
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    $luminance = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
    $textColorHex = $luminance < 128 ? '#ffffff' : '#374151'; // Blanco o Gris-700
@endphp

<script src="https://kit.fontawesome.com/4e519fa740.js" crossorigin="anonymous"></script>
<nav x-data="{ open: false }"
     style="background-color: {{ $bgColor }}; color: {{ $textColorHex }};"
     class="sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
        <div class="flex justify-between items-center h-16">

        <div class="flex-1 flex justify-start">
            <div class="flex-1 flex justify-start">
                @if (!request()->routeIs('dashboard'))
                    <button onclick="window.history.back();"
                            class="inline-flex items-center justify-center p-2 rounded-md hover:bg-white hover:bg-opacity-20 focus:outline-none focus:bg-white focus:bg-opacity-30 transition duration-150 ease-in-out"
                            aria-label="Volver"
                            title="Volver a la página anterior">
                        <i class="fa-solid fa-arrow-left fa-lg" style="color: {{ $textColorHex }};"></i>
                    </button>
                @else
                    {{-- Espacio reservado para mantener la alineación del logo --}}
                    <div class="w-[calc(1.25rem+1rem)] p-2"></div> {{-- Ancho y padding aprox. del botón de volver --}}
                @endif
            </div>

            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}">
                    @if ($appLogo)
                        <img src="{{ Storage::url($appLogo) }}" alt="{{ config('app.name', 'Laravel') }} Logo" class="block h-10 md:h-12 w-auto object-contain">
                    @else
                        <x-application-logo class="block h-10 md:h-12 w-auto fill-current" style="color: {{ $textColorHex }};" />
                    @endif
                </a>
            </div>

            <div class="flex-1 flex justify-end items-center">
                @auth
                <form method="POST" action="{{ route('logout') }}" class="flex items-center h-full p-0 m-0 ">
                    @csrf
 
                        <button type="submit" >Cerrar Sesión</button>

                </form>
                @endauth
          
            </div>
        </div>
    </div>

    {{-- <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        ... Todo el contenido del menú desplegable ha sido eliminado ...
    </div> --}}
</nav>
