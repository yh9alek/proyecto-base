<?php

namespace App\Models;

use App\Traits\HasPublicUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Perfil extends Model
{
    use HasFactory, HasPublicUlid;

    protected $table = 'perfiles';

    protected $fillable = [
        'ulid',
        'nombre',
        'descripcion',
        'usuario_alta',
        'usuario_mod',
    ];

    // ─────────────────────────────────────────
    // Relaciones
    // ─────────────────────────────────────────

    /** Módulos asignados a este perfil */
    public function modulos(): BelongsToMany
    {
        return $this->belongsToMany(Modulo::class, 'perfiles_modulos')
                    ->withTimestamps();
    }

    // ─────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────

    /**
     * Retorna los módulos raíz con sus hijos,
     * filtrados a los que este perfil tiene acceso.
     */
    public function modulosParaSidebar(): \Illuminate\Support\Collection
    {
        // IDs de todos los módulos a los que tiene acceso este perfil
        $modulosPermitidos = $this->modulos()->pluck('modulos.id');

        // Módulos raíz que el perfil tiene asignados directamente
        // o que tienen al menos un hijo asignado
        return Modulo::with(['children' => function ($query) use ($modulosPermitidos) {
                    $query->whereIn('id', $modulosPermitidos);
                }])
                ->raiz()
                ->where(function ($query) use ($modulosPermitidos) {
                    $query->whereIn('id', $modulosPermitidos)
                          ->orWhereHas('children', function ($q) use ($modulosPermitidos) {
                              $q->whereIn('id', $modulosPermitidos);
                          });
                })
                ->get();
    }
}