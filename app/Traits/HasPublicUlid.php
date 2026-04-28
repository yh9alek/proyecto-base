<?php

namespace App\Traits;

use Illuminate\Support\Str;

/**
 * No exponer publicamente IDs numéricos PK's y FK's.
 */
trait HasPublicUlid
{
    # La PK sigue siendo el id numérico autoincremental
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected static function bootHasPublicUlid(): void
    {
        static::creating(function ($model) {
            if (empty($model->ulid)) {
                $model->ulid = strtolower((string) Str::ulid());
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

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
}