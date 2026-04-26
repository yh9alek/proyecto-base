<?php

namespace App\Actions\Modulos;

use App\Models\Modulo;
use Illuminate\Support\Facades\DB;

class NormalizarOrdenModulosAction
{
    public function handle(?int $raizId, ?int $moduloAnclaId = null, ?int $ordenAncla = null): void
    {
        $modulos = Modulo::where('modulo_raiz_id', $raizId)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        if ($moduloAnclaId !== null && $ordenAncla !== null) {
            $ancla = $modulos->firstWhere('id', $moduloAnclaId);

            if ($ancla) {
                $modulos = $modulos->reject(fn($m) => $m->id === $moduloAnclaId)->values();
                $modulos->splice($ordenAncla - 1, 0, [$ancla]);
            }
        }

        $modulos->each(function ($modulo, $index) {
            $nuevoOrden = $index + 1;
            if ($modulo->orden !== $nuevoOrden) {
                $modulo->update(['orden' => $nuevoOrden]);
            }
        });
    }
}
