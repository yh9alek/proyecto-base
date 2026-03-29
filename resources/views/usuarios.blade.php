<x-app-layout>

    <h1 class="mb-2 text-[35px] font-bold">Usuarios</h1>
    <x-app.breadcrumb :links="[
        'Usuarios' => '/usuarios',
    ]" />

    <div class="max-w-175 mx-auto">
        <div id="tabla-usuarios"></div>
    </div>

    <x-modal id="modal-agregar" title="Agregar usuarios" size="max-w-2xl">

        <div class="grid grid-cols-6 gap-y-0 gap-x-10">

            <x-input.text 
                type="email" 
                label="Email:" 
                name="email"
                id="email"
                class="mt-1 border border-base-350"
                autofocus
                placeholder="example@gmail.com"
                autocomplete="username"

                :col-span="3"
                :value="old('email')"  
                :errors="$errors->get('email')"
            />

            <div class="col-span-full sm:col-span-3">
                <p for="select-usuarios" class="my-2 text-[13px]">Usuarios:</p>
                <div id="select-usuarios"></div>
            </div>

        </div>

        <x-slot:actions>
            <button class="btn btn-primary">
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
