<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModuloSeeder extends Seeder
{
    /**
     * Estructura real del sidebar.
     * children vacío = módulo sin hijos (enlace directo).
     */
    private array $estructura = [
        [
            'nombre'      => 'Panel de Control',
            'icono'       => 'dashboard',
            'url'         => '/panel-de-control',
            'descripcion' => 'Vista general del sistema.',
            'children'    => [],
        ],
        [
            'nombre'      => 'Administración',
            'icono'       => 'settings',
            'url'         => null,
            'descripcion' => 'Gestión de usuarios, roles y configuración.',
            'children'    => [
                ['nombre' => 'Usuarios',          'icono' => 'group',                'url' => '/usuarios'],
                ['nombre' => 'Roles y Permisos',  'icono' => 'admin_panel_settings', 'url' => '/roles-y-permisos'],
                ['nombre' => 'Auditoría',          'icono' => 'policy',               'url' => '/auditoria'],
                ['nombre' => 'Configuración',      'icono' => 'tune',                 'url' => '/configuracion'],
            ],
        ],
        [
            'nombre'      => 'Inventario',
            'icono'       => 'inventory_2',
            'url'         => null,
            'descripcion' => 'Control de bienes, almacenes y movimientos.',
            'children'    => [
                ['nombre' => 'Bienes Activos', 'icono' => 'category',   'url' => '/bienes-activos'],
                ['nombre' => 'Almacenes',       'icono' => 'warehouse',  'url' => '/almacenes'],
                ['nombre' => 'Entradas',        'icono' => 'input',      'url' => '/entradas'],
                ['nombre' => 'Salidas',         'icono' => 'output',     'url' => '/salidas'],
                ['nombre' => 'Reportes',        'icono' => 'bar_chart',  'url' => '/inventario/reportes'],
            ],
        ],
        [
            'nombre'      => 'Recursos Humanos',
            'icono'       => 'people',
            'url'         => null,
            'descripcion' => 'Gestión del capital humano.',
            'children'    => [
                ['nombre' => 'Empleados',      'icono' => 'badge',            'url' => '/empleados'],
                ['nombre' => 'Departamentos',  'icono' => 'corporate_fare',   'url' => '/departamentos'],
                ['nombre' => 'Nómina',          'icono' => 'payments',         'url' => '/nomina'],
                ['nombre' => 'Vacaciones',      'icono' => 'beach_access',     'url' => '/vacaciones'],
                ['nombre' => 'Asistencia',      'icono' => 'event_available',  'url' => '/asistencia'],
            ],
        ],
        [
            'nombre'      => 'Finanzas',
            'icono'       => 'account_balance',
            'url'         => null,
            'descripcion' => 'Control financiero y presupuestario.',
            'children'    => [
                ['nombre' => 'Cuentas por Cobrar',    'icono' => 'request_quote', 'url' => '/cuentas-por-cobrar'],
                ['nombre' => 'Cuentas por Pagar',     'icono' => 'receipt_long',  'url' => '/cuentas-por-pagar'],
                ['nombre' => 'Presupuestos',           'icono' => 'savings',       'url' => '/presupuestos'],
                ['nombre' => 'Egresos',               'icono' => 'money_off',     'url' => '/egresos'],
                ['nombre' => 'Ingresos',              'icono' => 'attach_money',  'url' => '/ingresos'],
                ['nombre' => 'Reportes Financieros',  'icono' => 'analytics',     'url' => '/finanzas/reportes'],
            ],
        ],
        [
            'nombre'      => 'Ventas',
            'icono'       => 'point_of_sale',
            'url'         => null,
            'descripcion' => 'Gestión del ciclo de ventas.',
            'children'    => [
                ['nombre' => 'Clientes',      'icono' => 'person',             'url' => '/clientes'],
                ['nombre' => 'Cotizaciones',  'icono' => 'description',        'url' => '/cotizaciones'],
                ['nombre' => 'Pedidos',       'icono' => 'shopping_cart',      'url' => '/pedidos'],
                ['nombre' => 'Facturas',      'icono' => 'receipt',            'url' => '/facturas'],
                ['nombre' => 'Devoluciones',  'icono' => 'assignment_return',  'url' => '/ventas/devoluciones'],
            ],
        ],
        [
            'nombre'      => 'Compras',
            'icono'       => 'shopping_bag',
            'url'         => null,
            'descripcion' => 'Gestión de proveedores y órdenes de compra.',
            'children'    => [
                ['nombre' => 'Proveedores',        'icono' => 'local_shipping',      'url' => '/proveedores'],
                ['nombre' => 'Órdenes de Compra',  'icono' => 'add_shopping_cart',   'url' => '/ordenes-de-compra'],
                ['nombre' => 'Recepción',          'icono' => 'move_to_inbox',       'url' => '/recepcion'],
                ['nombre' => 'Devoluciones',       'icono' => 'undo',                'url' => '/compras/devoluciones'],
            ],
        ],
        [
            'nombre'      => 'Proyectos',
            'icono'       => 'folder_special',
            'url'         => null,
            'descripcion' => 'Seguimiento de proyectos y tareas.',
            'children'    => [
                ['nombre' => 'Mis Proyectos',  'icono' => 'work',            'url' => '/mis-proyectos'],
                ['nombre' => 'Tareas',          'icono' => 'task_alt',        'url' => '/tareas'],
                ['nombre' => 'Cronograma',      'icono' => 'calendar_month',  'url' => '/cronograma'],
                ['nombre' => 'Recursos',        'icono' => 'engineering',     'url' => '/proyectos/recursos'],
                ['nombre' => 'Avances',         'icono' => 'trending_up',     'url' => '/avances'],
            ],
        ],
        [
            'nombre'      => 'Soporte',
            'icono'       => 'support_agent',
            'url'         => null,
            'descripcion' => 'Atención a usuarios y base de conocimiento.',
            'children'    => [
                ['nombre' => 'Tickets',               'icono' => 'confirmation_number',  'url' => '/tickets'],
                ['nombre' => 'Base de Conocimiento',  'icono' => 'menu_book',            'url' => '/base-de-conocimiento'],
                ['nombre' => 'Chat en Vivo',          'icono' => 'chat',                 'url' => '/chat-en-vivo'],
                ['nombre' => 'Encuestas',             'icono' => 'poll',                 'url' => '/encuestas'],
            ],
        ],
        [
            'nombre'      => 'Notificaciones',
            'icono'       => 'notifications',
            'url'         => '/notificaciones',
            'descripcion' => 'Centro de notificaciones del sistema.',
            'children'    => [],
        ],
        [
            'nombre'      => 'Reportes Generales',
            'icono'       => 'summarize',
            'url'         => null,
            'descripcion' => 'Reportes y exportaciones globales.',
            'children'    => [
                ['nombre' => 'Estadísticas',    'icono' => 'insert_chart',   'url' => '/estadisticas'],
                ['nombre' => 'Exportar Datos',  'icono' => 'download',       'url' => '/exportar-datos'],
                ['nombre' => 'Programados',     'icono' => 'schedule_send',  'url' => '/reportes-programados'],
            ],
        ],
        [
            'nombre'      => 'Mi Perfil',
            'icono'       => 'manage_accounts',
            'url'         => '/mi-perfil',
            'descripcion' => 'Configuración de la cuenta del usuario.',
            'children'    => [],
        ],
        [
            'nombre'      => 'Ayuda',
            'icono'       => 'help_outline',
            'url'         => '/ayuda',
            'descripcion' => 'Documentación y soporte.',
            'children'    => [],
        ],
    ];

    public function run(): void
    {
        foreach ($this->estructura as $data) {
            $children = $data['children'];
            unset($data['children']);

            /** @var Modulo $raiz */
            $raiz = Modulo::create([
                'modulo_raiz_id' => null,
                'icono'          => $data['icono'],
                'nombre'         => $data['nombre'],
                'descripcion'    => $data['descripcion'],
                'url'            => $data['url'],
                'usuario_alta'   => 1,
                'usuario_mod'    => 1,
            ]);

            foreach ($children as $child) {
                Modulo::create([
                    'modulo_raiz_id' => $raiz->id,
                    'icono'          => $child['icono'],
                    'nombre'         => $child['nombre'],
                    'descripcion'    => $child['nombre'] . ' — submódulo de ' . $raiz->nombre,
                    'url'            => $child['url'],
                    'usuario_alta'   => 1,
                    'usuario_mod'    => 1,
                ]);
            }
        }
    }
}