@php
    $settings = app(App\Settings\AppearanceSettings::class);
    $bgColor = $settings->app_color ?? '#4f46e5';
@endphp
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-400 leading-tight mx-auto text-center flex justify-center items-center h-20 pt-6">
                {{ __('Opciones de Clases') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 ">

                            {{-- Botón para Listas del Día (Inscritos) --}}
                            <a href="{{ route('admin.reports.daily_signups') }}"  style="background-color: {{ $bgColor }};"
                               class="block p-6 text-white rounded-lg shadow-md transition-colors duration-150 text-center">
                                <div class="text-2xl mb-2">
                                    <i class="fa-solid fa-clipboard-list"></i>
                                </div>
                                <span class="font-semibold text-lg">Ver Listas de Inscritos del Día</span>
                                <p class="text-sm opacity-80 mt-1">Consulta quién está apuntado a las clases de hoy/mañana.</p>
                            </a>

                            {{-- Botón para Gestionar Clases (CRUD) --}}
                            <a href="{{ route('admin.gym_classes.index') }}"  style="background-color: {{ $bgColor }};"
                               class="block p-6 text-white rounded-lg shadow-md transition-colors duration-150 text-center">
                                <div class="text-2xl mb-2">
                                    <i class="fa-solid fa-calendar-alt"></i> {{-- O fa-solid fa-dumbbell --}}
                                </div>
                                <span class="font-semibold text-lg">Gestionar Clases</span>
                                <p class="text-sm opacity-80 mt-1">Crear, editar o eliminar clases del sistema.</p>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
    