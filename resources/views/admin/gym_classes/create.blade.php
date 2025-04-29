<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nueva Clase') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

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

                    <form method="POST" action="{{ route('admin.gym_classes.store') }}" class="space-y-6">
                        @csrf

                        {{-- Nombre Clase --}}
                        <div>
                            <x-input-label for="name" :value="__('Nombre Clase')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>


                        {{-- Hora Inicio --}}
                        <div>
                            <x-input-label for="start_time" :value="__('Hora Inicio (HH:MM)')" />
                            <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time')" required />
                            <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                        </div>

                        {{-- Duración --}}
                        <div>
                            <x-input-label for="duration_minutes" :value="__('Duración (minutos)')" />
                            <x-text-input id="duration_minutes" class="block mt-1 w-full" type="number" name="duration_minutes" :value="old('duration_minutes', 60)" required min="15" />
                            <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                        </div>

                        {{-- Capacidad --}}
                        <div>
                            <x-input-label for="capacity" :value="__('Capacidad Máxima')" />
                            <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity', 10)" required min="1" />
                            <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                        </div>

                        {{-- Día de la Semana --}}
                        <div>
                            <x-input-label for="day_of_week" :value="__('Día de la Semana')" />
                            <select name="day_of_week" id="day_of_week" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled {{ old('day_of_week') === null ? 'selected' : '' }}>-- Selecciona Día --</option>
                                {{-- Usamos el estándar ISO-8601: 1 (Lunes) a 7 (Domingo) --}}
                                <option value="1" {{ old('day_of_week') == '1' ? 'selected' : '' }}>Lunes</option>
                                <option value="2" {{ old('day_of_week') == '2' ? 'selected' : '' }}>Martes</option>
                                <option value="3" {{ old('day_of_week') == '3' ? 'selected' : '' }}>Miércoles</option>
                                <option value="4" {{ old('day_of_week') == '4' ? 'selected' : '' }}>Jueves</option>
                                <option value="5" {{ old('day_of_week') == '5' ? 'selected' : '' }}>Viernes</option>
                                <option value="6" {{ old('day_of_week') == '6' ? 'selected' : '' }}>Sábado</option>
                                <option value="7" {{ old('day_of_week') == '7' ? 'selected' : '' }}>Domingo</option>
                            </select>
                            <x-input-error :messages="$errors->get('day_of_week')" class="mt-2" />
                        </div>

                        
                        {{-- Categoría (Select) --}}
                        <div>
                            <x-input-label for="id_categories" :value="__('Categoría')" />
                            <select name="id_categories" id="id_categories" required class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled {{ old('id_categories') ? '' : 'selected' }}>-- Selecciona Categoría --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('id_categories') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_categories')" class="mt-2" />
                        </div>

                         {{-- Instructor (Select) --}}
                        <div>
                            <x-input-label for="id_instructor" :value="__('Instructor (Opcional)')" />
                            <select name="id_instructor" id="id_instructor" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" {{ old('id_instructor') ? '' : 'selected' }}>-- Sin Asignar --</option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ old('id_instructor') == $instructor->id ? 'selected' : '' }}>
                                        {{ $instructor->name }} {{-- Asume que el modelo User tiene 'name' --}}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('id_instructor')" class="mt-2" />
                        </div>


                        {{-- Botones --}}
                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Guardar Clase') }}</x-primary-button>
                            <a href="{{ route('admin.gym_classes.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                {{ __('Cancelar') }}
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
