<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

/**
 * Inyecta un endpoint para obtener datos sin paginado.
 * Usar solo cuando la carga de datos sea menor.
 * LIMITE: 100 registros.
 */
trait Listable
{
    public function list() {

        $model = new $this->model();

        $query = DB::table($model->getTable())
            ->select(['ulid', ...$model->getIndexed()])
            ->limit(100);

        return response()->json($query->get());
    }
}
