<?php

namespace App\Actions\Modulos;

use App\Models\Modulo;

class ResolverOrdenModuloAction {

    public function handle(?int $ordenSolicitado, ?int $raizId, ?int $moduloActualId = null, ?int $raizAnteriorId = null): int
    {
        $mismaRaiz = $moduloActualId !== null && $raizAnteriorId === $raizId;

        $maxOrden = Modulo::where('modulo_raiz_id', $raizId)
            ->when($mismaRaiz, fn($q) => $q->where('id', '!=', $moduloActualId))
            ->max('orden') ?? 0;

        if (is_null($ordenSolicitado)) {
            return $maxOrden + 1;
        }

        return max(1, min($ordenSolicitado, $maxOrden + 1));
    }

}