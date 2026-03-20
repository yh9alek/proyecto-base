<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('perfil_id')
                  ->nullable()               // nullable: un usuario puede no tener perfil aún
                  ->after('remember_token')
                  ->constrained('perfiles')
                  ->nullOnDelete();          // si se borra el perfil, el usuario queda sin perfil
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['perfil_id']);
            $table->dropColumn('perfil_id');
        });
    }
};