<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PerfilSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perfiles')->insert([
            'id'            => 1,
            'ulid'          => Str::ulid(),
            'nombre'        => 'Administrador',
            'descripcion'   => 'Perfil con acceso total al sistema',
            'estatus'       => 1,
            'usuario_alta'  => 1,
            'created_at'    => now(),
        ]);
    }
}