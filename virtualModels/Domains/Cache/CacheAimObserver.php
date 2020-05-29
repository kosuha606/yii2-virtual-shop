<?php

namespace app\virtualModels\Domains\Cache;

class CacheAimObserver
{
    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    public function beforeSave(CacheAimInterface $aim)
    {
        /** @var CacheEntityDto $cacheEntityDto */
        foreach ($aim->cacheItems() as $cacheEntityDto) {
            $this->saveOneEntity($cacheEntityDto);
        }
    }

    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    private function saveOneEntity(CacheEntityDto $cacheEntityDto)
    {
        $oldCache = CacheVm::many([
            'where' => [
                ['=', 'entity_id', $cacheEntityDto->getCacheId()],
                ['=', 'entity_class', $cacheEntityDto->getCacheClass()],
            ],
        ]);

        /** @var CacheVm $cache */
        foreach ($oldCache as $cache) {
            $cache->delete();
        }

        CacheVm::create([
            'entity_id' => $cacheEntityDto->getCacheId(),
            'entity_class' => $cacheEntityDto->getCacheClass(),
            'data' => json_encode($cacheEntityDto->getCacheData(), JSON_UNESCAPED_UNICODE),
        ])->save();
    }
}