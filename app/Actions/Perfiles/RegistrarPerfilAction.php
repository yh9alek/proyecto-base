<?php

namespace App\Actions\Perfiles;

use App\Models\Modulo;
use App\Models\Perfil;
use Illuminate\Support\Facades\DB;

class RegistrarPerfilAction
{
    public function handle(array $data): Perfil
    {
        return DB::transaction(function () use ($data) {
            $perfil = Perfil::create([
                'nombre'       => $data['nombre'],
                'descripcion'  => $data['descripcion'] ?? null,
            ]);

            if (!empty($data['modulos'])) {
                $perfil->modulos()->sync(
                    Modulo::whereIn('ulid', $data['modulos'])->pluck('id')
                );
            }

            return $perfil;
        });
    }
}
