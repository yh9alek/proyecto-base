<?php

namespace Database\Seeders;

use App\Models\Modulo;
use App\Models\Perfil;
use Illuminate\Database\Seeder;

class PerfilSeeder extends Seeder
{
    public function run(): void
    {
        $todosLosModulos = Modulo::pluck('id');

        // ── Súper Administrador ──────────────────────────────────────
        // Acceso total a todos los módulos
        $superAdmin = Perfil::create([
            'nombre'       => 'Súper Administrador',
            'descripcion'  => 'Acceso total al sistema.',
            'usuario_alta' => 1,
            'usuario_mod'  => 1,
        ]);
        $superAdmin->modulos()->attach($todosLosModulos);

        // ── Administrador ────────────────────────────────────────────
        // Sin módulos financieros ni nómina
        $admin = Perfil::create([
            'nombre'       => 'Administrador',
            'descripcion'  => 'Acceso administrativo sin módulos financieros sensibles.',
            'usuario_alta' => 1,
            'usuario_mod'  => 1,
        ]);
        $modulosAdmin = Modulo::whereNotIn('nombre', [
            'Nómina', 'Cuentas por Cobrar', 'Cuentas por Pagar',
            'Presupuestos', 'Egresos', 'Ingresos', 'Reportes Financieros',
        ])->pluck('id');
        $admin->modulos()->attach($modulosAdmin);

        // ── Recursos Humanos ─────────────────────────────────────────
        $rh = Perfil::create([
            'nombre'       => 'Recursos Humanos',
            'descripcion'  => 'Gestión de personal y nómina.',
            'usuario_alta' => 1,
            'usuario_mod'  => 1,
        ]);
        $modulosRH = Modulo::where(function ($q) {
            $q->whereIn('nombre', [
                'Recursos Humanos', 'Panel de Control',
                'Mi Perfil', 'Notificaciones', 'Ayuda',
            ])->orWhere('modulo_raiz_id', function ($sub) {
                $sub->select('id')
                    ->from('modulos')
                    ->where('nombre', 'Recursos Humanos');
            });
        })->pluck('id');
        $rh->modulos()->attach($modulosRH);

        // ── Ventas ───────────────────────────────────────────────────
        $ventas = Perfil::create([
            'nombre'       => 'Vendedor',
            'descripcion'  => 'Acceso al módulo de ventas y clientes.',
            'usuario_alta' => 1,
            'usuario_mod'  => 1,
        ]);
        $modulosVentas = Modulo::where(function ($q) {
            $q->whereIn('nombre', [
                'Ventas', 'Panel de Control',
                'Mi Perfil', 'Notificaciones', 'Ayuda',
            ])->orWhere('modulo_raiz_id', function ($sub) {
                $sub->select('id')->from('modulos')->where('nombre', 'Ventas');
            });
        })->pluck('id');
        $ventas->modulos()->attach($modulosVentas);

        // ── Solo Lectura (Reportes) ──────────────────────────────────
        $reportero = Perfil::create([
            'nombre'       => 'Reportes',
            'descripcion'  => 'Acceso de solo lectura a reportes y estadísticas.',
            'usuario_alta' => 1,
            'usuario_mod'  => 1,
        ]);
        $modulosReportes = Modulo::whereIn('nombre', [
            'Panel de Control', 'Reportes Generales', 'Estadísticas',
            'Exportar Datos', 'Programados', 'Mi Perfil', 'Notificaciones', 'Ayuda',
        ])->pluck('id');
        $reportero->modulos()->attach($modulosReportes);
    }
}