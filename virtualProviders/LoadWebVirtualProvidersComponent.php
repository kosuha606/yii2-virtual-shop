<?php

namespace app\virtualProviders;

use app\virtualProviders\ZendLuceneSearch\ZendLuceneSearchProvider;
use kosuha606\VirtualAdmin\Test\TestSearchProvider;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelEntity;
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

        VirtualModelManager::getInstance()
            ->setProvider(new SystemAlertProvider())
            ->setProvider(new FrameworkProvider())
            ->setProvider(new PermissionProvider())
            ->setProvider(new RequestProvider())
            ->setProvider(new SessionProvider())
            ->setProvider(new CacheProvider())
            ->setProvider(new CookieProvider())
            ->setProvider(new SettingsProvider())
            ->setProvider(new SitemapProvider())
            ->setProvider(new TransactionProvider())
            ->setProvider(new AutoTranslateProvider())
        ;

        $zendProvider = new ZendLuceneSearchProvider();
        $zendProvider->zendService->setIndexPath('@runtime/zend_index');
        VirtualModelManager::getInstance()->setProvider(new TestSearchProvider());

    }
}