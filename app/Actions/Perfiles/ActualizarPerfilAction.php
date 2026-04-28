<?php

namespace App\Actions\Perfiles;

use App\Models\Modulo;
use App\Models\Perfil;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ActualizarPerfilAction
{
    public function handle(array $data, Perfil $perfil): Perfil
    {
        return DB::transaction(function () use ($data, $perfil) {
                        
            $perfil->update([
                ...Arr::only($data, ['nombre', 'descripcion', 'estatus'])
            ]);

            if (array_key_exists('modulos', $data)) {
                $moduloIds = Modulo::whereIn('ulid', $data['modulos'] ?? [])->pluck('id');
                                
                $perfil->modulos()->sync($moduloIds);
            }

            return $perfil;
        });
    }
}
