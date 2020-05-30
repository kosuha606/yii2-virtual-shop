<?php

namespace app\virtualModels\Domains\Cache;

class CacheService
{
    /**
     * @param $entityClass
     * @param $whereConfig
     * @return CacheVm|null
     * @throws \Exception
     */
    public function one($entityClass, $whereConfig = [])
    {
        $tableName = CacheVm::normalizeTableName($entityClass);
        $data = CacheVm::getData($tableName, $whereConfig);

        if (!isset($data[0])) {
            return null;
        }

        return CacheVm::create($data[0]);
    }

    /**
     * @param $entityClass
     * @return CacheVm[]
     * @throws \Exception
     */
    public function many($entityClass, $whereConfig = [])
    {
        $tableName = CacheVm::normalizeTableName($entityClass);
        $data = CacheVm::getData($tableName, $whereConfig);

        $result = [];
        foreach ($data as $datum) {
            $result[] = CacheVm::create($datum);
        }

        return $result;
    }
}