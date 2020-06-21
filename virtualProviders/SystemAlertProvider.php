<?php

namespace app\virtualProviders;

use kosuha606\VirtualAdmin\Model\Alert;
use kosuha606\VirtualModel\Example\MemoryModelProvider;

class SystemAlertProvider extends MemoryModelProvider
{
    public function type()
    {
        return 'system_alert';
    }

    public function flush()
    {
        /** @var Alert $model */
        foreach ($this->persistedModels as $model) {
            \Yii::$app->session->addFlash($model->type, $model->message);
        }

        return parent::flush();
    }
}