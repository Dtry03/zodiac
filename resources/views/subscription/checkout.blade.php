<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Completar Suscripción para') }} {{ $tenant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-2xl para un contenido más centrado --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    {{-- Mensaje de estado si viene de la redirección del registro --}}
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-md">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="mb-6 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-md">
                            {{ session('warning') }}
                        </div>
                    @endif
                     @if (session('error'))
                        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-md">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            ¡Casi listo, {{ Auth::user()->name }}!
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Para activar completamente tu gimnasio "{{ $tenant->name }}" y acceder a todas las funcionalidades, por favor completa tu suscripción mensual.
                        </p>
                        {{-- Aquí podrías mostrar detalles del plan si tienes varios --}}
                        {{-- <p class="mt-4 text-sm text-gray-500 dark:text-gray-300">
                            Plan seleccionado: Plan Mensual Básico - [Precio]/mes.
                        </p> --}}
                    </div>

                    {{-- Formulario que redirige a Stripe Checkout --}}
                    {{-- Este formulario enviará a la ruta 'subscription.checkout.process' que crearemos después --}}
                    <form method="POST" action="{{ route('subscription.checkout.process', $tenant) }}" class="mt-6">
                        @csrf
                        <div class="flex justify-center">
                            <x-primary-button type="submit">
                                <i class="fa-brands fa-stripe fa-lg mr-2"></i> {{-- Icono de Stripe (opcional) --}}
                                {{ __('Proceder al Pago con Stripe') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="mt-6 text-center text-xs text-gray-500 dark:text-gray-400">
                        Serás redirigido a la plataforma segura de Stripe para completar el pago.
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
