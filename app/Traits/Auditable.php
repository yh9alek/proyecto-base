<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

trait Auditable
{
    /**
     * Se ejecuta automáticamente cuando un modelo usa este trait.
     */
    public static function bootAuditable()
    {
        // Evento ANTES de crear el registro
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->usuario_alta = Auth::id();
                $model->usuario_mod  = null;
                $model->updated_at   = null;
            }
        });

        // Evento ANTES de actualizar el registro
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->usuario_mod = Auth::id();
            }
        });
    }

    public function userAlta(): BelongsTo {
        return $this->belongsTo(User::class, 'usuario_alta');
    }

    public function userMod(): BelongsTo {
        return $this->belongsTo(User::class, 'usuario_mod');
    }
}
