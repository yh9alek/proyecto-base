<x-app-layout>
     
    
    <h1 class="mb-2 text-[35px] font-bold">Nomina</h1>
    <x-app.breadcrumb :links="[
        'Panel' => '/dashboard',
        'Usuarios' => '/users',
        'Editar Usuario' => null
    ]" />

    <x-modal id="mi-modal" title="Confirmar acción" size="max-w-lg">

        <x-alert type="warning" title="Título"> Cuidado, se viene proyecto para TMAZ. </x-alert>

        <x-slot:actions>
            <button class="btn btn-primary">Confirmar</button>
        </x-slot:actions>

    </x-modal>            

    <button class="btn btn-primary" onclick="document.getElementById('mi-modal').showModal()">Hola que hace</button>


</x-app-layout>
