<?php

namespace app\virtualModels\Domains\Cache;

class CacheService
{
    /**
     * @param $entityId
     * @param $entityClass
     * @return CacheVm
     * @throws \Exception
     */
    public function one($entityId, $entityClass)
    {
        $cache = CacheVm::one(['where' => [
            ['=', 'entity_id', $entityId],
            ['=', 'entity_class', $entityClass],
        ]]);

        return $cache;
    }

    /**
     * @param $entityClass
     * @return CacheVm[]
     * @throws \Exception
     */
    public function many($entityClass)
    {
        $caches = CacheVm::many([
            'where' => [
                ['=', 'entity_class', $entityClass],
            ]
        ]);

        return $caches;
    }
}