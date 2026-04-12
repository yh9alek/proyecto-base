<?php

namespace App\Services;

use App\Http\Resources\ModuloResource;
use App\Models\Modulo;
use Illuminate\Database\Eloquent\Builder;

final class ModuloGridService extends GridService
{
    protected function model(): string    { return Modulo::class;         }
    protected function resource(): string { return ModuloResource::class; }

    protected function aplicarBusqueda(Builder $query, string $search): Builder
    {
        return $query->where('nombre',  'like', "{$search}%")
                     ->orWhere('icono', 'like', "{$search}%");
    }

    
}