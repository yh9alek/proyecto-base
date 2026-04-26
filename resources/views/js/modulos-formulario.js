const selectModulos = new Select('#select-modulos', {
    url: '/modulos_raiz',
    name: 'modulo-dependiente',
    labelKey: 'nombre',
    valueKey: 'ulid',
    searchable: false,
});

const btnEliminar = document.getElementById('btn-eliminar');

btnEliminar.addEventListener('click', async () => {

    const confirmo = await mostrarConfirmacion('Advertencia', '¿Esta seguro de eliminar este módulo?');

    if(confirmo) {
        try {
            await axios.delete(obtenerShowPath());
            setTimeout(() => { window.location.href = '/modulos'; }, 500);
        } catch (error) {}
    }

});