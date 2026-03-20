<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            // Autorreferencia: null = módulo raíz
            $table->foreignId('modulo_raiz_id')
                  ->nullable()
                  ->constrained('modulos')
                  ->nullOnDelete();

            $table->string('icono', 30);
            $table->string('nombre', 30);
            $table->text('descripcion')->nullable();
            $table->text('url')->nullable();         // null en módulos que solo agrupan hijos

            $table->unsignedBigInteger('usuario_alta');
            $table->unsignedBigInteger('usuario_mod');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modulos');
    }
};