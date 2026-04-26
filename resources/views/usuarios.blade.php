<x-app-layout>

    <x-app.title> Usuarios </x-app.title>
    <x-app.breadcrumb :links="[
        'Usuarios' => '/usuarios',
    ]" />

    <div class="max-w-175 mx-auto">
        <div id="tabla-usuarios"></div>
    </div>

    <x-modal id="modal-agregar" title="Agregar usuarios" size="max-w-2xl">

        <form novalidate id="usuarios-form" class="grid grid-cols-1 sm:grid-cols-12 gap-y-0 gap-x-10">

            <div class="col-span-full sm:col-span-4">
                <p class="mt-2 mb-1 text-[13px]">Perfil: <span class="text-error">*</span></p>
                <div id="select-perfil" data-key=""></div>
            </div>

            <x-input.text 
                type="text" 
                label="Nombre:" 
                name="name"
                id="name"
                autofocus
                placeholder="Escriba el nombre"
                required

                :col-span="4"
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
                type="password" 
                label="Contraseña:" 
                name="password"
                id="password"
                autofocus
                placeholder="********"
                required

                :col-span="4"
            />

        </form>

        <x-slot:actions>
            <button type="submit" form="usuarios-form" class="btn btn-primary">
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
