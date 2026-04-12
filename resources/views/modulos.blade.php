<x-app-layout>

    <h1 class="mb-2 text-[35px] font-bold">Módulos Principales</h1>
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