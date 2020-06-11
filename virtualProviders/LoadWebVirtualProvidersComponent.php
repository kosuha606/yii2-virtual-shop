<?php

namespace app\virtualProviders;

use app\virtualProviders\ZendLuceneSearch\ZendLuceneSearchProvider;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelManager;
use yii\base\Component;

class LoadWebVirtualProvidersComponent extends Component
{
    public $arRelations = [];

    /**
     * @throws \Exception
     */
    public function init()
    {
        $arProvider = new ActiveRecordProvider();
        $arProvider->relations = $this->arRelations;
        VirtualModelManager::getInstance()->setProvider($arProvider);

        VirtualModelManager::getInstance()->setProvider(new SystemAlertProvider());

        VirtualModelManager::getInstance()->setProvider(new PermissionProvider());

        VirtualModelManager::getInstance()->setProvider(new RequestProvider());

        VirtualModelManager::getInstance()->setProvider(new SessionProvider());

        VirtualModelManager::getInstance()->setProvider(new CacheProvider());

        VirtualModelManager::getInstance()->setProvider(new SettingsProvider());

        VirtualModelManager::getInstance()->setProvider(new SitemapProvider());

        VirtualModelManager::getInstance()->setProvider(new TransactionProvider());

        $zendProvider = new ZendLuceneSearchProvider();
        $zendProvider->zendService->setIndexPath('@runtime/zend_index');
        VirtualModelManager::getInstance()->setProvider($zendProvider);

    }
}