<x-app-layout>

    <h1 class="mb-2 text-[35px] font-bold">Usuarios</h1>
    <x-app.breadcrumb :links="[
        'Usuarios' => '/usuarios',
    ]" />

    <div class="max-w-175 mx-auto">
        <div id="tabla-usuarios"></div>
    </div>

    @push('scripts')
        @vite('resources/views/js/usuarios.js')
    @endpush

</x-app-layout>
