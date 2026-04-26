<?php

namespace App\Actions\Modulos;

use App\Models\Modulo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrarModuloAction
{
    public function __construct(
        private ResolverOrdenModuloAction    $resolverOrdenModulo,
        private NormalizarOrdenModulosAction $normalizarOrdenModulos,
    ) {}

    public function handle(array $data): Modulo {

        return DB::transaction(function () use ($data) {

            $raizId = $this->resolverRaizId($data);
            $orden = $this->resolverOrdenModulo->handle($data['orden'] ?? null, $raizId);

            # Registramos el nuevo módulo
            $modulo = Modulo::create([
                'nombre'         => $data['nombre'],
                'icono'          => $data['icono'],
                'uri'            => $data['uri'],
                'descripcion'    => $data['descripcion'] ?? null,
                'modulo_raiz_id' => $raizId,
                'orden'          => $orden,
            ]);

            # Añadimos el módulo creado al perfil de Administrador
            Auth::user()->perfil->modulos()->attach($modulo->id);

            # Normalizamos el orden de los módulos
            $this->normalizarOrdenModulos->handle($raizId, $modulo->id, $orden);
            return $modulo;
        });
    }

    private function resolverRaizId(array $data): ?int {
        return !empty($data['modulo-dependiente'])
            ? Modulo::moduloDependienteID($data['modulo-dependiente'])->value('id')
            : null;
    }
}
