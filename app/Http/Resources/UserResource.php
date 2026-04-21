<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ulid'         => $this->ulid,
            'name'         => $this->name,
            'email'        => $this->email,
            'perfil'       => $this->perfil?->nombre,
            'perfilUlid'   => $this->perfil?->ulid,
            'estatus'      => $this->estatus,
            'usuario_alta' => $this->userAlta?->name,
            'created_at'   => $this->created_at,
            'usuario_mod'  => $this->userMod?->name,
            'updated_at'   => $this->updated_at
        ];
    }
}
