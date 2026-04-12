<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ModuloResource extends JsonResource
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
            'modulo_raiz_ulid' => $this->moduloRaiz?->ulid,
            'ulid'         => $this->ulid,
            'nombre'       => $this->nombre,
            'icono'        => $this->icono,
            'descripcion'  => $this->descripcion,
            'url'          => $this->url,
            'orden'        => $this->orden,
            'estatus'      => $this->estatus,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'usuario_alta' => $usuarioAlta,
            'usuario_mod'  => $usuarioMod
        ];
    }
}
