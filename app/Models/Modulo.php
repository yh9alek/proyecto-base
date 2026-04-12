<?php

namespace App\Models;

use App\Traits\HasPublicUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class Modulo extends Model
{
    use HasApiTokens, HasFactory, HasPublicUlid;

    protected $table = 'modulos';

    protected $fillable = [
        'ulid',
        'modulo_raiz_id',
        'icono',
        'nombre',
        'descripcion',
        'uri',
        'orden',
        'estatus',
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
        return $this->hasMany(Modulo::class, 'modulo_raiz_id')
                    ->orderBy('orden');
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

    /** ID de Módulo Raiz */
    protected function scopeModuloDependienteID($query, $ulid) {
        return $query->where('ulid', $ulid);
    }

    /** ULID de Módulo Raiz */
    protected function scopeModuloDependienteULID($query, $id) {
        return $query->where('id', $id);
    }

    public static function normalizarOrden(?int $raizId, ?int $moduloAnclaId = null, ?int $ordenAncla = null): void
    {
        $modulos = Modulo::where('modulo_raiz_id', $raizId)
            ->orderBy('orden')
            ->orderBy('id')
            ->get();

        // Si hay un módulo ancla (el que se está moviendo), lo reposicionamos en la colección
        if ($moduloAnclaId && $ordenAncla) {
            $modulos = $modulos->filter(fn($m) => $m->id !== $moduloAnclaId)->values();
            $modulos->splice($ordenAncla - 1, 0, [Modulo::find($moduloAnclaId)]);
            $modulos = collect($modulos);
        }

        $modulos->each(function ($modulo, $index) {
            $nuevoOrden = $index + 1;
            if ($modulo->orden !== $nuevoOrden) {
                $modulo->update(['orden' => $nuevoOrden]);
            }
        });
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->updated_at = null;
        });
    }
}