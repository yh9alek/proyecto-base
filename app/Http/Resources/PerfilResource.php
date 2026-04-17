<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerfilResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $usuarioAlta = User::query()->where('id', '=', $this->usuario_alta)->first(['name']);
        $usuarioMod  = User::query()->where('id', '=', $this->usuario_mod)->first(['name']);

        return [
            'ulid'         => $this->ulid,
            'nombre'       => $this->nombre,
            'descripcion'  => $this->descripcion,
            'estatus'      => $this->estatus,
            'usuario_alta' => $usuarioAlta,
            'created_at'   => $this->created_at,
            'usuario_mod'  => $usuarioMod,
            'updated_at'   => $this->updated_at
        ];
    }
}
