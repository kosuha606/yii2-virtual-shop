<?php

namespace app\virtualModels\Admin\Test;

use app\models\Cache;
use app\virtualModels\Domains\Cache\CacheProviderInterface;
use app\virtualModels\Domains\Cache\CacheVm;
use kosuha606\VirtualModel\VirtualModelProvider;

class TestCacheProvider extends VirtualModelProvider implements CacheProviderInterface
{
    public function type()
    {
        return CacheVm::KEY;
    }

    public function environemnt(): string
    {
        // TODO: Implement environemnt() method.
    }

    protected function findOne($modelClass, $config)
    {
        // TODO: Implement findOne() method.
    }

    protected function findMany($modelClass, $config)
    {
        // TODO: Implement findMany() method.
    }

    public function normalizeTableName($caller, $name)
    {
        // TODO: Implement normalizeTableName() method.
    }

    public function buildColumnsByData($caller, $data)
    {
        // TODO: Implement buildColumnsByData() method.
    }

    public function createTable($caller, $tableName, $fieldsConfig)
    {
        // TODO: Implement createTable() method.
    }

    public function dropTable($caller, $tableName)
    {
        // TODO: Implement dropTable() method.
    }

    public function isTableExists($caller, $tableName)
    {
        // TODO: Implement isTableExists() method.
    }

    public function getData($caller, $tableName, $whereConfig)
    {
        // TODO: Implement getData() method.
    }

    public function insertData($caller, $tableName, $whereConfig)
    {
        // TODO: Implement insertData() method.
    }

    public function deleteData($caller, $tableName, $whereConfig)
    {
        // TODO: Implement deleteData() method.
    }
}