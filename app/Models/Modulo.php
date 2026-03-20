<?php

namespace App\Models;

use App\Traits\HasPublicUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Modulo extends Model
{
    use HasFactory, HasPublicUlid;

    protected $table = 'modulos';

    protected $fillable = [
        'ulid',
        'modulo_raiz_id',
        'icono',
        'nombre',
        'descripcion',
        'url',
        'usuario_alta',
        'usuario_mod',
    ];

    // ─────────────────────────────────────────
    // Relaciones
    // ─────────────────────────────────────────

    /** Módulo padre (raíz) */
    public function moduloRaiz(): BelongsTo
    {
        return $this->belongsTo(Modulo::class, 'modulo_raiz_id');
    }

    /** Hijos directos de este módulo */
    public function children(): HasMany
    {
        return $this->hasMany(Modulo::class, 'modulo_raiz_id');
    }

    /** Perfiles que tienen acceso a este módulo */
    public function perfiles(): BelongsToMany
    {
        return $this->belongsToMany(Perfil::class, 'perfiles_modulos')
                    ->withTimestamps();
    }

    // ─────────────────────────────────────────
    // Scopes
    // ─────────────────────────────────────────

    /** Solo módulos raíz (sin padre) */
    public function scopeRaiz($query)
    {
        return $query->whereNull('modulo_raiz_id');
    }

    /** Módulos raíz con sus hijos cargados */
    public function scopeConHijos($query)
    {
        return $query->raiz()->with('children');
    }
}