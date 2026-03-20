<?php

namespace Database\Factories;

use App\Models\Perfil;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    protected $model = Perfil::class;

    public function definition(): array
    {
        return [
            // ulid se genera automáticamente por HasPublicUlid
            'nombre'       => $this->faker->jobTitle(),
            'descripcion'  => $this->faker->sentence(),
            'usuario_alta' => 1,
            'usuario_mod'  => 1,
        ];
    }
}