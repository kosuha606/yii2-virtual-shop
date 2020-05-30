<?php

namespace app\virtualModels\Domains\Cache;

class CacheAimObserver
{
    private function createCacheTable($tableName, $data)
    {
        $fieldsConfig = CacheVm::buildColumnsByData($data);

        CacheVm::createTable($tableName, $fieldsConfig);
    }

    private function normalizeEntityData($data)
    {
        foreach ($data as $key => &$datum) {
            if (is_array($datum)) {
                $datum = json_encode($datum, JSON_UNESCAPED_UNICODE);
            }
        }

        return $data;
    }

    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    public function beforeSave(CacheAimInterface $aim)
    {
        /** @var CacheEntityDto $cacheEntityDto */
        foreach ($aim->cacheItems() as $cacheEntityDto) {
            $tableName = 'cache_'.$cacheEntityDto->getCacheClass();

            if (!CacheVm::isTableExists($tableName)) {
                $this->createCacheTable($tableName, $cacheEntityDto->getCacheData());
            }

            $this->saveOneEntity($tableName, $cacheEntityDto);
        }
    }

    /**
     * @param CacheAimInterface $aim
     * @throws \Exception
     */
    private function saveOneEntity($tableName, CacheEntityDto $cacheEntityDto)
    {
        // Очищаем стырй кэш
        CacheVm::deleteData($tableName, ['=', $cacheEntityDto->getCacheIdField(), $cacheEntityDto->getCacheId()]);

        // Создаем новый кэш
        $normalizedCacheData = $this->normalizeEntityData($cacheEntityDto->getCacheData());
        CacheVm::insertData($tableName, $normalizedCacheData);
    }
}