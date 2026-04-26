<?php

namespace App\Actions\Modulos;

use App\Models\Modulo;
use Illuminate\Support\Facades\DB;

class ActualizarModuloAction
{
    public function __construct(
        private ResolverOrdenModuloAction    $resolverOrdenModulo,
        private NormalizarOrdenModulosAction $normalizarOrdenModulos,
    ) {}

    public function handle(array $data, Modulo $modulo): Modulo {

        return DB::transaction(function () use ($modulo, $data) {

            # Obtenemos IDs y resolvemos orden
            $raizAnteriorId = $modulo->modulo_raiz_id;
            $raizId = $this->resolverRaizId($data);

            $orden = $this->resolverOrdenModulo->handle(
                $data['orden'] ?? null,
                $raizId,
                $modulo->id,
                $raizAnteriorId
            );

            # Primero actualizamos el módulo con su nuevo orden
            $modulo->update([
                'nombre'         => $data['nombre'],
                'icono'          => $data['icono'],
                'uri'            => $data['uri'],
                'descripcion'    => $data['descripcion'] ?? null,
                'modulo_raiz_id' => $raizId,
                'orden'          => $orden,
            ]);

            # Luego normalizamos, ya con el módulo en su nueva posición
            $this->normalizarOrdenModulos->handle($raizId, $modulo->id, $orden);

            if ($raizAnteriorId !== $raizId) {
                $this->normalizarOrdenModulos->handle($raizAnteriorId);
            }

            return $modulo;
        });
    }

    private function resolverRaizId(array $data): ?int
    {
        return !empty($data['modulo-dependiente'])
            ? Modulo::moduloDependienteID($data['modulo-dependiente'])->value('id')
            : null;
    }
}
