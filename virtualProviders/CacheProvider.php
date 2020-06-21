<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Domains\Cache\CacheProviderInterface;
use kosuha606\VirtualAdmin\Domains\Cache\CacheVm;
use kosuha606\VirtualModel\VirtualModelProvider;
use Yii;
use yii\db\Query;

/**
 * Провайдер для логики кэша для ее использования в рамках Yii2
 */
class CacheProvider extends VirtualModelProvider implements CacheProviderInterface
{
    public function type()
    {
        return CacheVm::KEY;
    }

    public function environemnt(): string
    {
        return 'cache';
    }

    protected function findOne($modelClass, $config)
    {
        return null;
    }

    protected function findMany($modelClass, $config)
    {
        return [];
    }

    public function buildColumnsByData($caller, $data)
    {
        $fieldsConfig = [];

        foreach ($data as $key => $item) {
            if (is_array($item)) {
                $fieldsConfig[$key] = 'TEXT';
            }

            if (is_int($item)) {
                $fieldsConfig[$key] = 'INT(11)';
            }

            if (is_string($item)) {
                $fieldsConfig[$key] = 'VARCHAR(255)';
            }
        }

        return $fieldsConfig;
    }

    public function normalizeTableName($caller, $name)
    {
        return 'cache_'.$name;
    }

    /**
     * @param $caller
     * @param $tableName
     * @param $fieldsConfig
     * @throws \yii\db\Exception
     */
    public function createTable($caller, $tableName, $fieldsConfig)
    {
        $result = Yii::$app->db->queryBuilder->createTable($tableName, $fieldsConfig);
        Yii::$app->db->createCommand($result)->execute();
    }

    /**
     * @param $caller
     * @param $tableName
     * @throws \yii\db\Exception
     */
    public function dropTable($caller, $tableName)
    {
        $sql = Yii::$app->db->queryBuilder->dropTable($tableName);
        Yii::$app->db->createCommand($sql)->execute();
    }

    public function isTableExists($caller, $tableName)
    {
        $schema = Yii::$app->db->getTableSchema($tableName);

        return (bool)$schema;
    }

    public function getData($caller, $tableName, $config)
    {
        $query = new Query();
        $query->from($tableName);

        if (isset($config['where'])) {
            foreach ($config['where'] as $whereConfig) {
                switch ($whereConfig[0]) {
                    case '=':
                        $query->andWhere([$whereConfig[1] => $whereConfig[2]]);
                        break;
                    case 'in':
                    case 'like':
                    case '>':
                    case '<':
                    case '>=':
                    case '<=':
                        $query->andWhere([$whereConfig[0], $whereConfig[1], $whereConfig[2]]);
                        break;
                }
            }
        }

        if (isset($config['select'])) {
            $query->select($config['select']);
        }

        if (isset($config['orderBy'])) {
            $query->orderBy($config['orderBy']);
        }

        if (isset($config['groupBy'])) {
            $query->groupBy($config['groupBy']);
        }

        if (isset($config['limit'])) {
            $query->limit($config['limit']);
        }

        if (isset($config['offset'])) {
            $query->offset($config['offset']);
        }

        return $query->all();
    }

    /**
     * @param $caller
     * @param $tableName
     * @param $data
     * @throws \yii\db\Exception
     */
    public function insertData($caller, $tableName, $data)
    {
        $schema = Yii::$app->db->getTableSchema($tableName);

        if (!$schema) {
            $columns = $this->buildColumnsByData($this, $data);
        } else {
            $columns = $schema->columns;
        }

        $columns = array_keys($columns);

        $insertData = [];
        foreach ($columns as $column) {
            $insertData[$column] = $data[$column];
        }

        Yii::$app->db->createCommand()->insert($tableName, $insertData)->execute();
    }

    /**
     * @param $caller
     * @param $tableName
     * @param $whereConfig
     * @throws \yii\db\Exception
     */
    public function deleteData($caller, $tableName, $whereConfig)
    {
        Yii::$app->db->createCommand()->delete($tableName, $whereConfig)->execute();
    }


}