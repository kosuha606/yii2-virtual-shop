<?php

namespace app\virtualProviders;

use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelManager;
use yii\base\Component;

class LoadWebVirtualProvidersComponent extends Component
{
    public $arRelations = [];

    public function init()
    {
        $arProvider = new ActiveRecordProvider();
        $arProvider->relations = $this->arRelations;

        VirtualModelManager::getInstance()->setProvider($arProvider);
    }
}