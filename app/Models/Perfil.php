<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\HasPublicUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Perfil extends Model
{
    use HasFactory, HasPublicUlid, Auditable;

    protected $table = 'perfiles';

    protected $fillable = [
        'ulid',
        'nombre',
        'descripcion',
        'estatus',
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

    public function usuarios(): HasMany {
        return $this->hasMany(User::class);
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
        $modulosPermitidos = $this->modulos()->pluck('modulos.id');

        return Modulo::with(['children' => function ($query) use ($modulosPermitidos) {
                    $query->whereIn('id', $modulosPermitidos)
                        ->where('estatus', 1)
                        ->orderBy('orden');
                }])
                ->raiz()
                ->where(function ($query) use ($modulosPermitidos) {
                    $query->whereIn('id', $modulosPermitidos)
                        ->orWhereHas('children', function ($q) use ($modulosPermitidos) {
                            $q->whereIn('id', $modulosPermitidos);
                        });
                })
                ->where('estatus', 1)
                ->orderBy('orden')
                ->get();
    }
}