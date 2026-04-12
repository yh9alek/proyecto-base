const modalAgregar = document.querySelector('#modal-agregar');

const btnAgregar = {
    text: 'Agregar',
    icon: 'add_circle',
    className: 'btn btn-primary btn-agregar',
    onClick: (grid) => modalAgregar.showModal()
};

// new Select('#select-usuarios', {
//     required: true,
//     url: '/usuarios/list',
//     serverSide: false,
//     labelKey: 'name',
//     valueKey: 'ulid',
//     name: 'user_id',
//     limit: 8,
// });

// new Grid('#tabla-usuarios', '/usuarios/list', {
//     headerButton: btnAgregar,
//     serverSide: false,
//     rowsPerPage: 8,
//     columns: [
//         { key: 'name',  label: 'Nombre' },
//         { 
//             key: 'email', label: 'Correo', 
//             render: (row) => `
//                 <div class="alert alert-warning px-4 py-2">${row.email}</div>
//             `
//         },
//         {
//             key: 'actions',
//             label: '...',
//             render: (row) => [
//                 `<button title="Editar" class="grid-button grid place-items-center h-7.5 tooltip" data-tip="Editar">
//                     <span class="material-symbols-rounded icon-filled color-base-content" style="font-size:18px;">
//                         edit_note
//                     </span>
//                 </button>`,
//                 `<button title="Eliminar" class="grid-button grid place-items-center h-7.5 tooltip" data-tip="Eliminar">
//                     <span class="material-symbols-rounded icon-filled" style="color:#FF6B6B; font-size:18px;">
//                         cancel
//                     </span>
//                 </button>`,
//                 `<button title="Info." class="grid-button grid place-items-center h-7.5 tooltip" data-tip="Info.">
//                     <span class="material-symbols-rounded icon-filled" style="color:var(--color-primary); font-size:18px;">
//                         info
//                     </span>
//                 </button>`,
//             ]
//         }
//     ],
// });

const validator = new FormValidator('#registrar-usuarios-form');