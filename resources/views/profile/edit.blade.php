<x-app-layout>
    <x-slot name="header">
  
        <h2 class="font-semibold text-xl text-gray-400 leading-tight mx-auto text-center flex justify-center items-center h-20 pt-6">
            {{ __('Editar Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-table-bg-color shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-table-bg-color shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-table-bg-color shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @if(auth()->user()->role === 'admin')
            <div class="p-4 sm:p-8 bg-table-bg-color shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('admin.settings.edit')
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
