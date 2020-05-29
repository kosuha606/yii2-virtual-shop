<?php

namespace app\virtualModels\Domains\Cache;

/**
 * Каждая сущность, которая хочет сохранять кэш своих данных
 * должна реализовывать этот интерфейс, обсервер не работает с
 * сущностями другого типа
 */
interface CacheAimInterface
{
    /** @return CacheEntityDto[] */
    public function cacheItems(): array;
}