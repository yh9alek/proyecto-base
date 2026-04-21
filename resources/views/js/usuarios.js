const modalAgregar = document.getElementById('modal-agregar');

let esUpdate    = false;
let usuarioUlid = null;

let selectPerfil = new Select('#select-perfil', {
    url: '/perfiles',
    name: 'perfil_ulid',
    labelKey: 'nombre',
    valueKey: 'ulid',
    searchable: false,
    required: true,
});

const abrirModalEditar = (row) => {
    
    modalAgregar.showModal();
    selectPerfil.setValue(row.perfilUlid);
    usuarioUlid = row.ulid;
    esUpdate = true;

    cargarFormulario('#usuarios-form', row);

};

const btnAgregar = {
    text: 'Agregar',
    icon: 'add_circle',
    className: 'btn btn-primary btn-agregar',
    onClick: (grid) => {
        modalAgregar.showModal();
        esUpdate = false;
    }
};

const tableUsuarios = new Grid('#tabla-usuarios', '/usuarios', {
    headerButton: btnAgregar,
    serverSide: false,
    rowsPerPage: 8,
    columns: [
        { key: 'name',  label: 'Nombre' },
        { key: 'email', label: 'Correo' },
        {
            key: 'actions',
            label: '...',
            render: (row) => [
                Grid.createAction({
                    title:   'Editar',
                    icon:    'edit_note',
                    onClick: () => abrirModalEditar(row),
                }),
 
                Grid.createAction({
                    title:   parseInt(row.estatus) ? 'Inhabilitar'          : 'Habilitar',
                    icon:    parseInt(row.estatus) ? 'check_circle'         : 'do_not_disturb_on',
                    color:   parseInt(row.estatus) ? 'var(--color-success)' : 'var(--color-error)',
                    onClick: async () => {

                        const mensaje = parseInt(row.estatus)
                            ? '¿Desea Inhabilitar a este usuario?'
                            : '¿Habilitar Usuario?';

                        const respuesta = await mostrarConfirmacion(mensaje);

                        const estatus   = Number(!Boolean(parseInt(row.estatus)));

                        if(respuesta) {
                            try {
                                await axios.put(`/usuarios/${row.ulid}`, { estatus });
                                tableUsuarios.recargarDatos();
                            } catch(error) {
                                console.error('Error: ', error);
                            }
                        }
                    },
                }),
 
                Grid.createAction({
                    title:   'Info.',
                    icon:    'info',
                    color:   'var(--color-primary)',
                    onClick: () => mostrarInfo(row),
                }),
            ]
        }
    ],
});

const validator = new FormValidator('#usuarios-form', {
    onSubmit: async (form, isValid) => {
        if (!isValid) return;

        const data = Object.fromEntries(new FormData(form));

        try {

            esUpdate ? await axios.put(`/usuarios/${usuarioUlid}`, data)
                     : await axios.post('/usuarios', data);
            
            tableUsuarios.recargarDatos();

        } catch (error) {
            console.error(error);
        }
    },
});