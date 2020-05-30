<?php

namespace app\virtualModels\Domains\Cache;

interface CacheProviderInterface
{
    public function normalizeTableName($caller, $name);

    public function buildColumnsByData($caller, $data);

    public function createTable($caller, $tableName, $fieldsConfig);

    public function dropTable($caller, $tableName);

    public function isTableExists($caller, $tableName);

    public function getData($caller, $tableName, $whereConfig);

    public function insertData($caller, $tableName, $whereConfig);

    public function deleteData($caller, $tableName, $whereConfig);
}