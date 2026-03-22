<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function data(Request $request)
    {
        $query = DB::table('users')
            ->select(['ulid', 'name', 'email']);

        // Búsqueda
        if ($search = $request->input('search')) {
            $query->whereRaw(
                "MATCH(name, email) AGAINST(? IN BOOLEAN MODE)",
                [$search]
            );
        }

        // Paginación
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

    // public function store(User $uuid) {

    // }
}
