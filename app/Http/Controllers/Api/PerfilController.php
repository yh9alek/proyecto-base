<?php

namespace App\Http\Controllers\Api;

use App\Actions\Perfiles\ActualizarPerfilAction;
use App\Actions\Perfiles\RegistrarPerfilAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerfilRequest;
use App\Http\Resources\PerfilCollection;
use App\Http\Resources\PerfilResource;
use App\Models\Perfil;

class PerfilController extends Controller
{
    public function index()
    {
        return new PerfilCollection(
            Perfil::with('modulos')->get()
        );
    }
 
    public function store(PerfilRequest $request, RegistrarPerfilAction $action)
    {
        $perfil = $action->handle($request->validated());

        return PerfilResource::make($perfil->load('modulos'))
            ->response()
            ->setStatusCode(201);
    }
 
    public function show(Perfil $perfil)
    {
        return PerfilResource::make($perfil->load('modulos'));
    }
 
    public function update(PerfilRequest $request, Perfil $perfil, ActualizarPerfilAction $action)
    {
        $perfil = $action->handle($request->validated(), $perfil);
        return PerfilResource::make($perfil->load('modulos'));
    }
 
    public function destroy(Perfil $perfil)
    {
        $perfil->delete();
        return response()->noContent();
    }
}
