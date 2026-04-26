<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ModuloRequest;
use App\Http\Resources\ModuloResource;
use App\Http\Resources\ModuloCollection;
use App\Models\Modulo;

class ModuloController extends Controller
{
    public function index() {
        $modulosRaiz = Modulo::whereNull('modulo_raiz_id')
            ->with(['children' => function ($query) {
                $query->orderBy('orden', 'asc'); 
            }])
            ->orderBy('orden', 'asc')
            ->get();

        $listaSecuencial = collect();

        foreach ($modulosRaiz as $padre) {
            $listaSecuencial->push($padre);

            if ($padre->children->isNotEmpty()) {
                foreach ($padre->children as $hijo) {
                    $listaSecuencial->push($hijo);
                }
            }
        }

        return new ModuloCollection($listaSecuencial);
    }

    public function update(ModuloRequest $request, Modulo $modulo) {
        $modulo->update($request->validated());
        return new ModuloResource($modulo);
    }

    public function destroy(Modulo $modulo) {
        $modulo->delete();
        return response()->noContent();
    }

    public function modulosRaiz() {
        return new ModuloCollection(
            Modulo::raiz()->get()
        );
    }

    public function arbol() {
        $tree = Modulo::whereNull('modulo_raiz_id')
            ->with(['children' => fn($q) => $q->orderBy('orden')])
            ->orderBy('orden')
            ->get()
            ->map(fn($raiz) => [
                'id'       => $raiz->ulid,
                'text'     => $raiz->nombre,
                'children' => $raiz->children->map(fn($hijo) => [
                    'id'   => $hijo->ulid,
                    'text' => $hijo->nombre,
                ])->values(),
            ])->values();
 
        return response()->json($tree);
    }
}
