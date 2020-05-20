<?php

namespace app\virtualProviders;

use kosuha606\VirtualModel\VirtualModel;
use Yii;
use app\virtualModels\Admin\Model\Session;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class SessionProvider extends MemoryModelProvider
{
    public function type()
    {
        return Session::TYPE;
    }

    public function findOne($modelClass, $config)
    {
        $data = Yii::$app->session->get($config['where'][0][2]);

        return $data;
    }

    public function findMany($modelClass, $config)
    {
        return [self::findOne($modelClass, $config)];
    }

    public function flush()
    {
        /** @var Session $model */
        foreach ($this->persistedModels as $model) {
            Yii::$app->session->set($model->key, $model->value);
        }

        return parent::flush();
    }

    public function delete(VirtualModel $model)
    {
        return parent::delete($model);
    }
}