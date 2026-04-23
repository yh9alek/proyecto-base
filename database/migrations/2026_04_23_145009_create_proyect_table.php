<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration')->index();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration')->index();
        });

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::create('modulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('ulid', 26)->unique();
            $table->unsignedBigInteger('modulo_raiz_id')->nullable()->index('modulos_modulo_raiz_id_foreign');
            $table->string('icono', 30);
            $table->string('nombre', 30);
            $table->text('descripcion')->nullable();
            $table->text('uri')->nullable();
            $table->tinyInteger('orden')->default(1);
            $table->unsignedTinyInteger('estatus')->default(1);
            $table->unsignedBigInteger('usuario_alta');
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->index(['icono', 'nombre'], 'modulos_idx_btree');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('perfiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('ulid', 26)->unique();
            $table->string('nombre', 30);
            $table->text('descripcion')->nullable();
            $table->unsignedTinyInteger('estatus')->default(1);
            $table->unsignedBigInteger('usuario_alta');
            $table->timestamp('created_at');
            $table->unsignedBigInteger('usuario_mod')->nullable();
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('perfiles_modulos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('perfil_id');
            $table->unsignedBigInteger('modulo_id')->index('perfiles_modulos_modulo_id_foreign');
            $table->timestamps();

            $table->unique(['perfil_id', 'modulo_id']);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('ulid', 26)->unique('inx_ulid_users');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->unsignedBigInteger('perfil_id')->nullable()->index('users_perfil_id_foreign');
            $table->tinyInteger('estatus')->default(1);
            $table->unsignedBigInteger('usuario_alta');
            $table->timestamp('created_at');
            $table->bigInteger('usuario_mod')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->fullText(['name', 'email'], 'idx_fulltext_users_search');
        });

        Schema::table('modulos', function (Blueprint $table) {
            $table->foreign(['modulo_raiz_id'])->references(['id'])->on('modulos')->onUpdate('restrict')->onDelete('set null');
        });

        Schema::table('perfiles_modulos', function (Blueprint $table) {
            $table->foreign(['modulo_id'])->references(['id'])->on('modulos')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['perfil_id'])->references(['id'])->on('perfiles')->onUpdate('restrict')->onDelete('cascade');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['perfil_id'])->references(['id'])->on('perfiles')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_perfil_id_foreign');
        });

        Schema::table('perfiles_modulos', function (Blueprint $table) {
            $table->dropForeign('perfiles_modulos_modulo_id_foreign');
            $table->dropForeign('perfiles_modulos_perfil_id_foreign');
        });

        Schema::table('modulos', function (Blueprint $table) {
            $table->dropForeign('modulos_modulo_raiz_id_foreign');
        });

        Schema::dropIfExists('users');

        Schema::dropIfExists('sessions');

        Schema::dropIfExists('perfiles_modulos');

        Schema::dropIfExists('perfiles');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('modulos');

        Schema::dropIfExists('jobs');

        Schema::dropIfExists('job_batches');

        Schema::dropIfExists('failed_jobs');

        Schema::dropIfExists('cache_locks');

        Schema::dropIfExists('cache');
    }
};
