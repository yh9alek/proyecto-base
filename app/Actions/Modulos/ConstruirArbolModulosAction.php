<?php

namespace App\Actions\Modulos;

use App\Models\Modulo;
use Illuminate\Support\Collection;

class ConstruirArbolModulosAction
{
    public function handle(array $ulidsAsignados = []): array
    {
        $raices = Modulo::whereNull('modulo_raiz_id')
            ->with(['children' => fn($q) => $q->orderBy('orden')])
            ->orderBy('orden')
            ->get();

        return $this->mapearNodos($raices, $ulidsAsignados);
    }

    private function mapearNodos(Collection $modulos, array $asignados): array
    {
        return $modulos->map(fn(Modulo $modulo) => [
            'id'       => $modulo->ulid,
            'text'     => $modulo->nombre,
            'state'    => ['selected' => in_array($modulo->ulid, $asignados, true)],
            'children' => $modulo->children
                ? $this->mapearNodos($modulo->children, $asignados)
                : [],
        ])->values()->toArray();
    }
}
