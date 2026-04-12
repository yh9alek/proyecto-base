<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class GridService
{
    // Cada subclase declara su modelo y resource
    abstract protected function model(): string;
    abstract protected function resource(): string;

    // Sobreescribir para agregar búsqueda personalizada por modelo
    protected function aplicarBusqueda(Builder $query, string $search): Builder
    {
        return $query;
    }

    // Sobreescribir para agregar joins, scopes, eager loading, etc.
    protected function consultaBase(): Builder
    {
        return $this->model()::query();
    }

    public function handle(Request $request): array
    {
        $query = $this->consultaBase();

        if ($search = $request->input('search')) {
            $query = $this->aplicarBusqueda($query, $search);
        }

        $limit     = (int) $request->input('limit', 7);
        $page      = (int) $request->input('page',  1);
        $paginator = $query->paginate($limit, ['*'], 'page', $page);

        $resource = $this->resource();

        return [
            'items' => $resource::collection($paginator->items()),
            'meta'  => [
                'total'     => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from'      => $paginator->firstItem() ?? 0,
                'to'        => $paginator->lastItem()  ?? 0,
            ],
        ];
    }
}