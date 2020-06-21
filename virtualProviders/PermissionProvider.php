<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Model\Permission;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use yii\web\HttpException;

class PermissionProvider extends MemoryModelProvider
{
    public function type()
    {
        return Permission::TYPE;
    }

    public function throw403()
    {
        throw new HttpException(403, 'Доступ запрещен');
    }

    protected function findOne($modelClass, $config)
    {
        if (\Yii::$app->user->isGuest) {
            return [];
        }

        if (\Yii::$app->user->identity->username !== 'admin') {
            return [];
        }

        $data = [];

        foreach($config['where'] as $whereConfig) {
            $data[$whereConfig[1]] = $whereConfig[2];
        }

        return $data;
    }
}