<?php

namespace App\Http\Resources;

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
        return [
            'modulo_raiz_ulid' => $this->moduloRaiz?->ulid,
            'ulid'         => $this->ulid,
            'nombre'       => $this->nombre,
            'icono'        => $this->icono,
            'descripcion'  => $this->descripcion,
            'url'          => $this->url,
            'orden'        => $this->orden,
            'estatus'      => $this->estatus,
            'usuario_alta' => $this->userAlta?->name,
            'created_at'   => $this->created_at,
            'usuario_mod'  => $this->userMod?->name,
            'updated_at'   => $this->updated_at
        ];
    }
}
