<?php

namespace App\Http\Controllers;

use App\Actions\ResolverOrdenModulo;
use App\Http\Requests\ModuloRequest;
use App\Models\Modulo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use SweetAlert2\Laravel\Swal;

class ModuloController extends Controller
{
    public function index() {
        return view('modulos');
    }

    public function create() {
        return view('modulos-formulario');
    }

    public function store(ModuloRequest $request)
    {
        $data   = $request->validated();
        $raizId = null;
        $msg = ['icon'  => 'error', 'title' => 'Ocurrió un error al registrar el módulo'];

        if(!empty($data['modulo-dependiente'])) {
            $raizId = Modulo::moduloDependienteID($data['modulo-dependiente'])->value('id');
        }

        DB::transaction(function () use ($data, $raizId, &$msg) {

            $orden = app(ResolverOrdenModulo::class)->handle($data['orden'] ?? null, $raizId);

            $modulo = Modulo::create([
                'nombre'         => $data['nombre'],
                'icono'          => $data['icono'],
                'uri'            => $data['uri'],
                'descripcion'    => $data['descripcion'] ?? null,
                'modulo_raiz_id' => $raizId,
                'orden'          => $orden,
            ]);

            Auth::user()->perfil->modulos()->attach($modulo->id);
            Modulo::normalizarOrden($raizId, $modulo->id, $orden);

            $msg = ['icon'  => 'success','title' => 'Se registró el módulo correctamente'];

        });

        Swal::fire($msg);
        return to_route('modulos.index');
    }

    public function edit(Modulo $modulo) {

        $titulo = 'Editar Módulo';
        $accion = 'Edición';

        $moduloDepUlid = Modulo::moduloDependienteULID($modulo->modulo_raiz_id)->value('ulid');

        return view('modulos-formulario', compact('modulo', 'moduloDepUlid', 'titulo', 'accion'));
    }

    public function update(ModuloRequest $request, Modulo $modulo)
    {
        $msg    = ['icon' => 'error', 'title' => 'Ocurrió un error al actualizar'];
        $data   = $request->validated();
        $raizAnteriorId = $modulo->modulo_raiz_id;
        $raizId = null;

        if (!empty($data['modulo-dependiente'])) {
            $raizId = Modulo::moduloDependienteID($data['modulo-dependiente'])->value('id');
        }

        DB::transaction(function () use ($modulo, $data, &$msg, $raizId, $raizAnteriorId) {

            $orden = app(ResolverOrdenModulo::class)->handle(
                $data['orden'] ?? null,
                $raizId,
                $modulo->id,
                $raizAnteriorId
            );

            // Primero actualizamos el módulo con su nuevo orden
            $modulo->update([
                'nombre'         => $data['nombre'],
                'icono'          => $data['icono'],
                'uri'            => $data['uri'],
                'descripcion'    => $data['descripcion'] ?? null,
                'modulo_raiz_id' => $raizId,
                'orden'          => $orden,
            ]);

            // Luego normalizamos, ya con el módulo en su nueva posición
            Modulo::normalizarOrden($raizId, $modulo->id, $orden);

            if ($raizAnteriorId !== $raizId) {
                Modulo::normalizarOrden($raizAnteriorId);
            }

            $msg = ['icon' => 'success', 'title' => 'Se actualizó el registro correctamente'];
        });

        Swal::fire($msg);
        return to_route('modulos.index');
    }
}
