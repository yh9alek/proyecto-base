<x-app-layout>

    <h1 class="mb-2 text-[35px] font-bold">{{ $titulo ?? 'Registrar nuevo Módulo' }}</h1>
    <x-app.breadcrumb :links="[
        'Modulos' => '/modulos',
        $accion ?? 'Registro' => '',
    ]" />

    <form id="registro-modulo" class="max-w-200 grid grid-cols-12 gap-3 grid-flow-dense" action="{{ !isset($modulo) ? route('modulos.store') : route('modulos.update', compact('modulo')) }}" method="POST">
        @csrf
        @method(!isset($modulo) ? 'POST' : 'PUT')

        <div class="col-span-full grid grid-cols-12">
            <div class="col-span-full sm:col-span-3">
                <p class="mt-2 mb-1 text-[13px]">Módulo dependiente:</p>
                <div id="select-modulos" data-key="{{ $moduloDepUlid ?? '' }}"></div>
            </div>
        </div>

         <div class="divider col-span-full">Información del módulo</div>

        <x-input.text

            label="Nombre:"
            type="text"
            id="nombre"
            name="nombre"
            placeholder="Nombre del módulo"
            required

            :value="$modulo->nombre ?? ''"

            :errorMessages="$errors->get('nombre')"
            :col-span="6"

        />

        <x-input.text

            label="Ícono:"
            type="text"
            id="icono"
            name="icono"
            placeholder="Ícono"
            required

            :value="$modulo->icono ?? ''"

            :errorMessages="$errors->get('icono')"
            :col-span="3"

        />

        <x-input.text

            label="URI:"
            type="text"
            id="uri"
            name="uri"
            placeholder="Ruta"

            :value="$modulo->uri ?? ''"

            :errorMessages="$errors->get('uri')"
            :col-span="3"

        />

        <x-input.text

            label="Descripción:"
            type="text"
            id="descripcion"
            name="descripcion"
            placeholder="..."

            :value="$modulo->descripcion ?? ''"
            
            :col-span="9"

        />

        <x-input.text

            label="Orden:"
            type="number"
            id="orden"
            name="orden"
            placeholder="00"
            min="1"

            :value="$modulo->orden ?? ''"
            
            :errorMessages="$errors->get('orden')"
            :col-span="3"

        />

        <button type="submit" form="registro-modulo" class="btn btn-primary col-span-full sm:col-span-3">
            <span class="material-symbols-rounded">
                save
            </span>
            Guardar
        </button>
        <button type="button" class="btn btn-error col-span-full sm:col-span-3" id="btn-eliminar">
            <span class="material-symbols-rounded">
                delete
            </span>
            Eliminar
        </button>

    </form>
    @push('scripts')
        @vite('resources/views/js/modulos-formulario.js')
    @endpush

</x-app-layout>