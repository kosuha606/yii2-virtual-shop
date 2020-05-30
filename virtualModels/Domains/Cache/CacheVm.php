<?php

namespace app\virtualModels\Domains\Cache;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $entity_id
 * @property $entity_class
 * @property $data
 *
 * @method static buildColumnsByData($data)
 * @method static createTable($tableName, $fieldsConfig)
 * @method static dropTable($tableName)
 * @method static isTableExists($tableName)
 * @method static getData($tableName, $whereConfig)
 * @method static insertData($tableName, $whereConfig)
 * @method static deleteData($tableName, $whereConfig)
 *
 */
class CacheVm extends VirtualModel
{
    const KEY = 'cache';

    public static function providerType()
    {
        return self::KEY;
    }

    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'data',
        ];
    }
}