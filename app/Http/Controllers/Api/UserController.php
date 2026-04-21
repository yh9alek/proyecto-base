<?php

namespace App\Http\Controllers\Api;

use App\Actions\PrepararDataUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return new UserCollection(
            User::with(['perfil', 'userAlta', 'userMod'])->get()
        );
    }

    public function store(UserRequest $request, PrepararDataUserAction $action)
    {
        $data = $action->handle($request->validated());
        $usuario = User::create($data);

        return new UserResource($usuario)
            ->response()
            ->setStatusCode(201);
    }

    public function show(User $usuario)
    {
        return new UserResource($usuario);
    }

    public function update(UserRequest $request, User $usuario, PrepararDataUserAction $action)
    {
        $data = $action->handle($request->validated());
        $usuario->update($data);

        return new UserResource($usuario);
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return response()->noContent();
    }
}
