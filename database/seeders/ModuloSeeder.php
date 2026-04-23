<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        $modulos = [
            [
                'nombre'   => 'Administración',
                'icono'    => 'settings',
                'uri'      => null,
                'orden'    => 1,
                'hijos'    => [
                    ['nombre' => 'Usuarios', 'icono' => 'group',          'uri' => '/usuarios', 'orden' => 2],
                    ['nombre' => 'Perfiles', 'icono' => 'account_circle', 'uri' => '/perfiles', 'orden' => 3],
                    ['nombre' => 'Módulos',  'icono' => 'iframe',         'uri' => '/modulos',  'orden' => 4],
                ],
            ],
        ];

        $ahora = now();

        foreach ($modulos as $raiz) {
            $raizId = DB::table('modulos')->insertGetId([
                'ulid'           => Str::ulid(),
                'modulo_raiz_id' => null,
                'icono'          => $raiz['icono'],
                'nombre'         => $raiz['nombre'],
                'uri'            => $raiz['uri'],
                'orden'          => $raiz['orden'],
                'estatus'        => 1,
                'usuario_alta'   => 1,
                'created_at'     => $ahora,
            ]);

            foreach ($raiz['hijos'] ?? [] as $hijo) {
                DB::table('modulos')->insert([
                    'ulid'           => Str::ulid(),
                    'modulo_raiz_id' => $raizId,
                    'icono'          => $hijo['icono'],
                    'nombre'         => $hijo['nombre'],
                    'uri'            => $hijo['uri'],
                    'orden'          => $hijo['orden'],
                    'estatus'        => 1,
                    'usuario_alta'   => 1,
                    'created_at'     => $ahora,
                ]);
            }
        }
    }
}