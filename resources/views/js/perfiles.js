let tablePerfiles = null;
let modoEdicion   = false;
let ulidEdicion   = null;
 
const modal   = document.getElementById('modal-perfiles');
const form    = document.getElementById('form-perfiles');
const btnConf = document.getElementById('btn-confirmar');
const btnEliminar = document.getElementById('btn-eliminar');
  
const validator = new FormValidator(form, {
    onSubmit: async (f, isValid) => {
        if (!isValid) return;
        await guardar();
    },
});
  
function inicializarArbol(datos) {
    if ($.jstree.reference('#jstree-modulos')) {
        $('#jstree-modulos').jstree('destroy');
    }
 
    $('#jstree-modulos').jstree({
        core: {
            data:   datos,
            themes: { dots: true, icons: false },
        },
        checkbox: {
            keep_selected_style: false,
            three_state:         true,
        },
        plugins: ['checkbox'],
    });
}
 
function obtenerSeleccionados() {
    const tree = $.jstree.reference('#jstree-modulos');
    if (!tree) return [];
    return tree.get_selected();
}
 
async function abrirModalCrear() {
    modoEdicion = false;
    ulidEdicion = null;
 
    document.getElementById('nombre').value      = '';
    document.getElementById('descripcion').value = '';
    document.querySelector('#modal-perfiles .modal-title').innerText = 'Crear perfil';
    document.getElementById('btn-eliminar').style.display = 'none';
    validator.reset();
 
    const res = await axios.get('/perfiles/modulos-arbol');
    inicializarArbol(res.data);
 
    modal.showModal();
}
 
async function abrirModalEditar({ ulid, nombre, descripcion }) {
    modoEdicion = true;
    ulidEdicion = ulid;
 
    document.querySelector('#modal-perfiles .modal-title').innerText = 'Editar perfil';
    document.getElementById('btn-eliminar').style.display = 'block';
    validator.reset();
 
    // Precargamos de inmediato con los datos de la fila (respuesta rápida)
    document.getElementById('nombre').value      = nombre      ?? '';
    document.getElementById('descripcion').value = descripcion ?? '';
 
    // Cargamos el árbol con la selección del perfil en paralelo
    const resArbol = await axios.get(`/perfiles/${ulid}/modulos-arbol`);
    inicializarArbol(resArbol.data);
 
    modal.showModal();
}
 
async function guardar() {
    const nombre      = document.getElementById('nombre').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const modulos     = obtenerSeleccionados();

    modal.close();
 
    if (modoEdicion) {
        await axios.put(`/perfiles/${ulidEdicion}`, { nombre, descripcion, modulos });
    } else {
        await axios.post('/perfiles', { nombre, descripcion, modulos });
    }
 
    await refrescarSidebar();
    tablePerfiles.recargarDatos();
}
  
btnConf.addEventListener('click', () => form.requestSubmit());

btnEliminar.addEventListener('click', async () => {

    const ok = await mostrarConfirmacion('¿Eliminar este perfil?\nEsta acción no se puede deshacer.');
    if (!ok) return;

    modal.close();

    await axios.delete(`/perfiles/${ulidEdicion}`);
    await refrescarSidebar();
    tablePerfiles.recargarDatos();

});
 
const btnAgregar = {
    text:      'Agregar',
    icon:      'add_circle',
    className: 'btn btn-primary',
    onClick:   () => abrirModalCrear(),
};
 
tablePerfiles = new Grid('#tabla-perfiles', '/perfiles', {
    headerButton: btnAgregar,
    serverSide:   false,
    dataPath:     'data',
    columns: [
        { key: 'nombre',      label: 'Nombre' },
        { key: 'descripcion', label: 'Descripción' },
        {
            key:    'actions',
            label:  '...',
            render: (row) => [
 
                Grid.createAction({
                    title:   'Editar',
                    icon:    'edit_note',
                    onClick: () => abrirModalEditar(row),
                }),
 
                Grid.createAction({
                    title:   parseInt(row.estatus) ? 'Desactivar'           : 'Activar',
                    icon:    parseInt(row.estatus) ? 'check_circle'         : 'do_not_disturb_on',
                    color:   parseInt(row.estatus) ? 'var(--color-success)' : 'var(--color-error)',
                    onClick: async () => {

                        const msg = parseInt(row.estatus)
                            ? '¿Desactivar este perfil?'
                            : '¿Reactivar este perfil?';

                        const ok = await mostrarConfirmacion(msg);
                        if (!ok) return;
 
                        const estatus = Number(!Boolean(parseInt(row.estatus)));
                        await axios.put(`/perfiles/${row.ulid}`, { estatus });
                        await refrescarSidebar();

                        tablePerfiles.recargarDatos();
                    },
                }),
 
                Grid.createAction({
                    title:   'Info.',
                    icon:    'info',
                    color:   'var(--color-primary)',
                    onClick: () => mostrarInfo(row),
                }),
            ],
        },
    ],
});