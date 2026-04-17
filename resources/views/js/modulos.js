let tableModulos = null;

const modalAgregar = document.getElementById('modal-agregar');

const btnAgregar = {
    text: 'Agregar',
    icon: 'add_circle',
    className: 'btn btn-primary btn-agregar',
    onClick: () => window.location.href = '/modulos/create'
};

tableModulos = new Grid('#tabla-modulos', '/modulos', {
    headerButton: btnAgregar,
    serverSide: false,
    dataPath: 'data',
    columns: [
        { key: 'nombre', label: 'Nombre' },
        { key: 'modulo_raiz_ulid', label: 'Tipo', render: (row) => `
            ${!row.modulo_raiz_ulid ? '<div class="badge badge-sm bg-[#4b55ec] text-white">Raíz</div>' 
                                    : '<div class="badge badge-xs bg-(--color-success) text-white p-1 rounded-full"><span class="material-symbols-rounded" style="font-size: 14px !important;">subdirectory_arrow_right</span></div>'}`
            },
        {
            key: 'icono', label: 'Ícono',
            render: (row) => `
                <span class="material-symbols-rounded">${row.icono}</span>
            `
        },
        {
            key: 'actions',
            label: '...',
            render: (row) => [

                Grid.createAction({
                    title: 'Editar',
                    icon: 'edit_note',
                    onClick: () => {
                        window.location.href = `/modulos/${row.ulid}/edit`
                    }
                }),

                Grid.createAction({

                    title: parseInt(row.estatus) ? 'Desactivar'   : 'Activar',
                    icon:  parseInt(row.estatus) ? 'check_circle' : 'do_not_disturb_on',
                    color: parseInt(row.estatus) ? 'var(--color-success)' : 'var(--color-error)',

                    onClick: async () => {

                        const mensaje   = parseInt(row.estatus) ? '¿Está seguro de desactivar este módulo?' : '¿Está seguro de reactivar este módulo?';
                        const respuesta = await mostrarConfirmacion(mensaje);

                        const estatus   = Number(!Boolean(parseInt(row.estatus)));

                        if(respuesta) {
                            try {
                                await axios.put(`/modulos/${row.ulid}`, { estatus });
                                await refrescarSidebar();
                                tableModulos.recargarDatos();
                            } catch(error) {
                                console.error('Error: ', error);
                            }
                        }
                    }
                }),

                Grid.createAction({
                    title: 'Info.',
                    icon: 'info',
                    color: 'var(--color-primary)',
                    onClick: () => {
                        mostrarInfo(row);
                    }
                }),
            ]
        }
    ],
});