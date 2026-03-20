<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfiles_modulos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('perfil_id')
                  ->constrained('perfiles')
                  ->cascadeOnDelete();

            $table->foreignId('modulo_id')
                  ->constrained('modulos')
                  ->cascadeOnDelete();

            // Evita duplicados: un perfil no puede tener el mismo módulo dos veces
            $table->unique(['perfil_id', 'modulo_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfiles_modulos');
    }
};