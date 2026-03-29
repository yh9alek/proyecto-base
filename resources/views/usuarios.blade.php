<x-app-layout>

    <h1 class="mb-2 text-[35px] font-bold">Usuarios</h1>
    <x-app.breadcrumb :links="[
        'Usuarios' => '/usuarios',
    ]" />

    <div class="max-w-175 mx-auto">
        <div id="tabla-usuarios"></div>
    </div>

    <x-modal id="modal-agregar" title="Agregar usuarios" size="max-w-2xl">

        <form novalidate id="registrar-usuarios-form" class="grid grid-cols-6 gap-y-0 gap-x-10">

            <x-input.text 
                type="email" 
                label="Email:" 
                name="email"
                id="email"
                autofocus
                placeholder="example@gmail.com"
                required

                :col-span="3"
            />

            <div class="col-span-full sm:col-span-3">
                <p class="mt-2 mb-1 text-[13px]">Usuarios: <span class="text-error">*</span></p>
                <div id="select-usuarios"></div>
            </div>

            <x-input.text
                type="text"
                label="Edad:"
                name="edad"
                id="edad"
                autofocus
                placeholder="asdasd"
                required

                :col-span="2"
            />
            <x-input.text 
                type="email" 
                label="Email:" 
                name="email"
                id="email"
                autofocus
                placeholder="example@gmail.com"
                required

                :col-span="4"
            />

            <x-input.text
                type="number"
                label="Edad:"
                name="edad"
                id="edad"
                autofocus
                placeholder="00"
                required

                :col-span="1"
            />

            <div class="col-span-2">
                <p class="mt-2 mb-1 text-[13px]">Usuarios: <span class="text-error">*</span></p>
                <input type="checkbox" class="checkbox checkbox-sm checkbox-secondary" required/>
            </div>

        </form>

        <x-slot:actions>
            <button type="submit" form="registrar-usuarios-form" class="btn btn-primary">
                <span class="material-symbols-rounded">
                    save
                </span>
                Guardar
            </button>
        </x-slot:actions>

    </x-modal>

    @push('scripts')
        @vite('resources/views/js/usuarios.js')
    @endpush

</x-app-layout>
