<x-app-layout>

    <x-app.title> Perfiles </x-app.title>
    <x-app.breadcrumb :links="[
        'Perfiles' => '/perfiles',
    ]" />

    <div class="max-w-200 mx-auto">
        <div id="tabla-perfiles"></div>
    </div>

    <x-modal id="modal-perfiles" size="max-w-2xl">

        <form novalidate id="form-perfiles" action="{{ route('perfiles.store') }}" method="POST"
            class="grid grid-cols-6 gap-3">
            @csrf

            <div class="col-span-full md:col-span-3">
                <x-input.text
                    label="Nombre:"
                    type="text"
                    name="nombre"
                    id="nombre"
                    required

                    :col-span="3"
                />

                <x-input.text
                    label="Descripción:"
                    type="text"
                    name="descripcion"
                    id="descripcion"

                    :col-span="3"
                />

                <button type="button" class="btn btn-error col-span-full sm:col-span-3 hidden" id="btn-eliminar">
                    <span class="material-symbols-rounded relative -top-2.5 xs:top-0.75">
                        delete
                    </span>
                    <span class="relative -top-3.75 xs:-top-0.5">Eliminar</span>
                </button>
            </div>

            <div class="col-span-full md:col-span-3">
                <p class="text-sm font-medium mb-1.25 text-[13px] mt-2">Módulos con acceso:</p>
                <div id="jstree-modulos"
                     class="border border-base-300 rounded-lg p-2 min-h-40 bg-base-200 text-sm overflow-auto max-h-80">
                </div>
            </div>

        </form>

        <x-slot:actions>
            <button class="btn btn-primary" id="btn-confirmar">Confirmar</button>
        </x-slot:actions>

    </x-modal>

    @push('scripts')
        @vite('resources/views/js/perfiles.js')
    @endpush

</x-app-layout>