<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Str;

/**
 * Trait UuidTrait
 * @package App\Entities\Traits
 */
trait UuidTrait
{
    /**
     *
     */
    public static function bootUuidTrait(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * @param Builder $query
     * @param string $uuid
     * @return Builder
     */
    public function scopeOfUuid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public static function getIdByUuid(string $uuid)
    {
        return self::ofUuid($uuid)->value('id');
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public static function findByUuid(string $uuid)
    {
        return self::ofUuid($uuid)->first();
    }

    /**
     * @param string $uuid
     * @return mixed
     * @throws ModelNotFoundException
     */
    public static function findByUuidOrFail(string $uuid)
    {
        return self::ofUuid($uuid)->firstOrFail();
    }
}
