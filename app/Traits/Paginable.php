<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Inyecta un endpoint para paginar datos.
 * Útil para componentes que requieran carga de datos server-side.
 * Es necesario definir las propiedades tabla y campos en el controlador.
 */
trait Paginable
{
    public function data(Request $request)
    {
        $model = new $this->model();

        $query = DB::table($model->getTable())
            ->select(['ulid', ...$model->getIndexed()]);

        if ($search = $request->input('search')) {
            $query->where_full_text($model->getIndexed(), $search);
        }

        $perPage  = $request->input('limit', 8);
        $paginate = $query->paginate($perPage);

        return response()->json([
            'items' => $paginate->items(),
            'meta'  => [
                'total'        => $paginate->total(),
                'last_page'    => $paginate->lastPage(),
                'current_page' => $paginate->currentPage(),
                'from'         => $paginate->firstItem(),
                'to'           => $paginate->lastItem(),
            ],
        ]);
    }
}
