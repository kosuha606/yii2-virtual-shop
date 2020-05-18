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

        $alertProvider = new SystemAlertProvider();

        $permissionProvider = new PermissionProvider();

        VirtualModelManager::getInstance()->setProvider($alertProvider);
        VirtualModelManager::getInstance()->setProvider($permissionProvider);
        VirtualModelManager::getInstance()->setProvider($arProvider);
    }
}