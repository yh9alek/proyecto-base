<?php

namespace App\Actions;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PrepararDataUserAction
{
    public function handle(array $data): array {

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        if (isset($data['perfil_ulid'])) {
            $data['perfil_id'] = Perfil::query()
                ->where('ulid', $data['perfil_ulid'])
                ->value('id');
            unset($data['perfil_ulid']);
        }

        return $data;
    }
}
