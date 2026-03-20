<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PerfilModulo extends Pivot
{
    protected $table = 'perfiles_modulos';

    public $timestamps = true;

    protected $fillable = [
        'perfil_id',
        'modulo_id',
    ];
}