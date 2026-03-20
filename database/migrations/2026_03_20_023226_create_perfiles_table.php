<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perfiles', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();

            $table->string('nombre', 30);
            $table->text('descripcion')->nullable();

            $table->unsignedBigInteger('usuario_alta');
            $table->unsignedBigInteger('usuario_mod');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perfiles');
    }
};