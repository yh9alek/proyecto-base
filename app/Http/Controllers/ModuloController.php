<?php

namespace App\Http\Controllers;

use App\Actions\Modulos\ActualizarModuloAction;
use App\Actions\Modulos\RegistrarModuloAction;
use App\Http\Requests\ModuloRequest;
use App\Models\Modulo;
use Exception;
use Illuminate\Support\Facades\Log;
use SweetAlert2\Laravel\Swal;

class ModuloController extends Controller
{
    public function index() {
        return view('modulos');
    }

    public function create() {
        return view('modulos-formulario');
    }

    public function store(ModuloRequest $request, RegistrarModuloAction $action)
    {
        try {

            $action->handle($request->validated());
            
            Swal::fire(['icon' => 'success', 'title' => 'Se registró el módulo correctamente']);
            return to_route('modulos.index');

        } catch(Exception $e) {

            Log::error($e);
            Swal::fire(['icon' => 'error', 'title' => 'Ocurrió un error al registrar']);
            return back()->withInput();

        }
    }

    public function edit(Modulo $modulo) {

        $titulo = 'Editar Módulo';
        $accion = 'Edición';

        $moduloDepUlid = Modulo::moduloDependienteULID($modulo->modulo_raiz_id)->value('ulid');

        return view('modulos-formulario', compact('modulo', 'moduloDepUlid', 'titulo', 'accion'));
    }

    public function update(ModuloRequest $request, Modulo $modulo, ActualizarModuloAction $action)
    {
        try {

            $action->handle($request->validated(), $modulo);

            Swal::fire(['icon' => 'success', 'title' => 'Se actualizó el registro correctamente']);
            return to_route('modulos.index');

        } catch(Exception $e) {

            Log::error($e);
            Swal::fire(['icon' => 'error', 'title' => 'Ocurrió un error al actualizar']);
            return back()->withInput();

        }
    }
}
