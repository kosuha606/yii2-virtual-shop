<?php

namespace app\virtualProviders;

use app\virtualModels\Admin\Domains\Sitemap\SitemapProviderInterface;
use app\virtualModels\Admin\Domains\Sitemap\SitemapService;
use kosuha606\VirtualModel\VirtualModelProvider;
use kosuha606\VirtualModelHelppack\ServiceManager;
use samdark\sitemap\Sitemap;
use yii\helpers\Url;

class SitemapProvider extends VirtualModelProvider implements SitemapProviderInterface
{
    public function type()
    {
        return SitemapProviderInterface::class;
    }

    public function getBaseUrl()
    {
        return Url::base(true);
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function getSitemapContent()
    {
        $seoService = ServiceManager::getInstance()->get(SitemapService::class);
        $sitemapVm = $seoService->buildSitemap();
        $sitemapPath = \Yii::getAlias('@runtime/sitemap.xml');
        $sitemap = new Sitemap($sitemapPath);

        foreach ($sitemapVm->items as $item) {
            $sitemap->addItem(
                $item->getUrl(),
                $item->getBuildDate(),
                $item->getFreq(),
                $item->getImportance()
            );
        }

        $sitemap->write();
        $sitemapContent = file_get_contents($sitemapPath);

        return $sitemapContent;
    }

    public function environemnt(): string
    {
        return 'sitemap';
    }

    protected function findOne($modelClass, $config)
    {
        return null;
    }

    protected function findMany($modelClass, $config)
    {
        return null;
    }

}