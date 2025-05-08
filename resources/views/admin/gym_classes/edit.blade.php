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
            {{ __('Editar Clase') }}: {{ $gymClass->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-6 text-gray-400 bg-table-bg-color">

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

                    {{-- Formulario apunta a la ruta update con método PUT/PATCH --}}
                    <form method="POST" action="{{ route('admin.gym_classes.update', $gymClass) }}" class="space-y-6">
                        @csrf
                        @method('PUT') {{-- O PATCH --}}

                        {{-- Nombre Clase --}}
                        <div>
                            <x-input-label class="text-gray-400" for="name" :value="__('Nombre Clase')" />
                            {{-- Usar old() o el valor actual de la clase --}}
                            <x-text-input id="name" class="block mt-1 w-full  border-gray-400 bg-table-bg-color" type="text" name="name" :value="old('name', $gymClass->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- Hora Inicio --}}
                        <div>
                            <x-input-label class="text-gray-400" for="start_time" :value="__('Hora Inicio (HH:MM)')" />
                            {{-- Formatear la hora para el input type="time" --}}
                            <x-text-input id="start_time" class="block mt-1 w-full  border-gray-400 bg-table-bg-color" type="time" name="start_time" :value="old('start_time', \Carbon\Carbon::parse($gymClass->start_time)->format('H:i'))" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        {{-- Duración --}}
                        <div>
                            <x-input-label class="text-gray-400" for="duration_minutes" :value="__('Duración (minutos)')" />
                            <x-text-input id="duration_minutes" class="block mt-1 w-full  border-gray-400 bg-table-bg-color" type="number" name="duration_minutes" :value="old('duration_minutes', $gymClass->duration_minutes)" required min="15" />
                            <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                        </div>

                        {{-- Día de la Semana --}}
                        <div>
                            <x-input-label class="text-gray-400" for="day_of_week" :value="__('Día de la Semana')" />
                            <select name="day_of_week" id="day_of_week" required class="block mt-1 w-full  border-gray-400 bg-table-bg-color border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled>-- Selecciona Día --</option>
                                {{-- Usamos old() para mantener el valor si falla la validación, o el valor actual de la clase --}}
                                <option value="1" {{ old('day_of_week', $gymClass->day_of_week) == '1' ? 'selected' : '' }}>Lunes</option>
                                <option value="2" {{ old('day_of_week', $gymClass->day_of_week) == '2' ? 'selected' : '' }}>Martes</option>
                                <option value="3" {{ old('day_of_week', $gymClass->day_of_week) == '3' ? 'selected' : '' }}>Miércoles</option>
                                <option value="4" {{ old('day_of_week', $gymClass->day_of_week) == '4' ? 'selected' : '' }}>Jueves</option>
                                <option value="5" {{ old('day_of_week', $gymClass->day_of_week) == '5' ? 'selected' : '' }}>Viernes</option>
                                <option value="6" {{ old('day_of_week', $gymClass->day_of_week) == '6' ? 'selected' : '' }}>Sábado</option>
                                <option value="7" {{ old('day_of_week', $gymClass->day_of_week) == '7' ? 'selected' : '' }}>Domingo</option>
                            </select>
                            <x-input-error :messages="$errors->get('day_of_week')" class="mt-2" />
                        </div>

                        {{-- Capacidad --}}
                        <div>
                            <x-input-label class="text-gray-400" for="capacity" :value="__('Capacidad Máxima')" />
                            <x-text-input id="capacity" class="block mt-1 w-full  border-gray-400 bg-table-bg-color" type="number" name="capacity" :value="old('capacity', $gymClass->capacity)" required min="1" />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>

                        
                        {{-- Categoría (Select) --}}
                        <div>
                            <x-input-label class="text-gray-400" for="id_categories" :value="__('Categoría')" />
                            <select name="id_categories" id="id_categories" required class="block mt-1 w-full  border-gray-400 bg-table-bg-color border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled>-- Selecciona Categoría --</option>
                                @foreach ($categories as $category)
                                    {{-- Seleccionar la categoría actual --}}
                                    <option  value="{{ $category->id }}" {{ old('id_categories', $gymClass->id_categories) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_categories')" class="mt-2" />
                        </div>

                         {{-- Instructor (Select) --}}
                        <div>
                            <x-input-label class="text-gray-400" for="id_instructor" :value="__('Instructor (Opcional)')" />
                            <select name="id_instructor" id="id_instructor" class="block mt-1 w-full  border-gray-400 bg-table-bg-color border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">-- Sin Asignar --</option>
                                @foreach ($instructors as $instructor)
                                     {{-- Seleccionar el instructor actual --}}
                                    <option value="{{ $instructor->id }}" {{ old('id_instructor', $gymClass->id_instructor) == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_instructor')" class="mt-2" />
                        </div>


                        {{-- Botones --}}
                        <div class="flex items-center gap-4 mt-6">
                            <button style="background-color: {{ $bgColor }};" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{{ __('Actualizar Clase') }}</button>
                            <a href="{{ route('admin.gym_classes.index') }}" class="text-sm text-gray-400  hover:text-gray-300">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
