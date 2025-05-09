@php
    $settings = app(App\Settings\AppearanceSettings::class);
    $bgColor = $settings->app_color ?? '#4f46e5';
@endphp
<script src="https://kit.fontawesome.com/4e519fa740.js" crossorigin="anonymous"></script>
<x-app-layout>
    <x-slot name="header">
    </x-slot>
    @if(auth()->user()->role !== 'admin')
    <div class="flex items-center justify-center min-h-[calc(100vh-8rem)] w-screen">
        <div class="md:flex-col  lg:flex lg:flex-row justify-center items-center">
            <div class="px-20 py-5 text-center">
                <a href="{{ route('schedule.index') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-calendar-days py-4"></i></a>
                <span class="block text-2xl font-medium text-gray-100">Horario</span>
            </div>
            <div class="px-20 py-5 text-center">
                <a href="{{ route('schedule.today') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-dumbbell py-4"></i></a>
                <span class="block text-2xl font-medium text-gray-100">Clases</span>
            </div>
            <div class="px-20 py-5 text-center">
                <a href="{{ route('client.classes') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-clipboard-list py-4"></i></a>
                <span class="block text-2xl font-medium text-gray-100">Inscripciones</span>
            </div>
            <div class="px-20 py-5  text-center">
                <a href="{{ route('profile.edit') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-gear  py-4"></i></a>   
                <span class="block text-2xl font-medium text-gray-100">Ajustes</span>
            </div>
        </div>
    </div>
    @endif
    @if(auth()->user()->role === 'admin')
    <div class="flex items-center justify-center min-h-[calc(100vh-8rem)] w-screen">
        <div class="md:flex-col  lg:flex lg:flex-row justify-center items-center">
            <div class="px-20 py-5 text-center">
                <a href="{{ route('admin.gym_classes.index') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-dumbbell py-4"></i></a>
                <span class="block text-2xl font-medium text-gray-100">Clases</span>
            </div>
            <div class="px-20 py-5 text-center">
                <a href="{{ route('admin.users.index') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-users py-4"></i></a>
                <span class="block text-2xl font-medium text-gray-100">Usuarios</span>
            </div>
            <div class="px-20 py-5 text-center">
                <a href="{{ route('admin.categories.index') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-tags py-4"></i></a>
                <span class="block text-2xl font-medium text-gray-100">Categorías</span>
            </div>
            <div class="px-20 py-5  text-center">
                <a href="{{ route('profile.edit') }}"><i  style="color: {{ $bgColor }};" class="text-8xl fa-solid fa-gear  py-4"></i></a>   
                <span class="block text-2xl font-medium text-gray-100">Ajustes</span>
            </div>
        </div>
    </div>
    @endif


</x-app-layout>
