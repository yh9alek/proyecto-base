<x-app-layout>

    <x-app.title> Módulos Principales </x-app.title>
    <x-app.breadcrumb :links="[
        'Modulos' => '/modulos',
    ]" />

    <div class="max-w-125 mx-auto">
        <div id="tabla-modulos"></div>
    </div>
    @push('scripts')
        @vite('resources/views/js/modulos.js')
    @endpush

</x-app-layout>