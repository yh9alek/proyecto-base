<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Concerns\HasUlids;

/**
 * No exponer publicamente IDs numéricos PK's y FK's.
 */
trait HasPublicUlid
{
    use HasUlids;

    # La PK sigue siendo el id numérico autoincremental
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    # Solo la columna 'ulid' recibe el valor generado
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    # Sobrescribe toArray para ocultar id numérico y FKs al serializar
    public function toArray(): array
    {
        return collect(parent::toArray())
            ->except($this->internalKeys())
            ->toArray();
    }

    protected function internalKeys(): array
    {
        $fks = array_filter(
            array_keys($this->getAttributes()),
            fn($key) => str_ends_with($key, '_id')
        );

        return ['id', ...$fks];
    }

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }
}