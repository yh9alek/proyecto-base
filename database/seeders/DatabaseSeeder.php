<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Orden importante: módulos primero, luego perfiles (que los referencian)
        $this->call([
            ModuloSeeder::class,
            PerfilSeeder::class,
        ]);
    }
}