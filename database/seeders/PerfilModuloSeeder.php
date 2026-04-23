<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perfilAdminId = 1;
        $ahora = now();

        $registros = DB::table('modulos')
            ->pluck('id')
            ->map(fn ($moduloId) => [
                'perfil_id'  => $perfilAdminId,
                'modulo_id'  => $moduloId,
                'created_at' => $ahora,
                'updated_at' => $ahora,
            ])
            ->all();

        DB::table('perfiles_modulos')->insert($registros);
    }
}
