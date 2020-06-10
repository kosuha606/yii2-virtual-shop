<?php

namespace app\virtualModels\Admin\Domains\Sitemap;

use app\virtualModels\Admin\Domains\Seo\SeoModelInterface;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelManager;

class SitemapService
{
    /** @var SitemapProviderInterface */
    private $provider;

    /** @var SitemapVm  */
    private $sitemap;

    /**
     * SitemapService constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->provider = VirtualModelManager::getInstance()->getProvider(SitemapProviderInterface::class);
        $this->sitemap = SitemapVm::create([]);
    }

    /**
     * @return SitemapVm
     * @throws \Exception
     */
    public function buildSitemap(): SitemapVm
    {
        $storageProvider = VirtualModelManager::getInstance()->getProvider('storage');
        $storageClasses = $storageProvider->getAvailableModelClasses();
        $baseUrl = $this->provider->getBaseUrl();

        $seoPages = SeoPageVm::many(['where' => [
            ['=', 'entity_id', null]
        ]]);
        /** @var SeoPageVm $page */
        foreach ($seoPages as $page) {
            $this->addSeoPageToSitemap($baseUrl.$page->url, $page);
        }

        // Записываем в карту сайта все сущности
        /** @var VirtualModel $storageClass */
        foreach ($storageClasses as $storageClass) {
            if (class_implements($storageClass, SeoModelInterface::class)) {
                $models = $storageClass::many(['where' => [['all']]]);

                /** @var SeoModelInterface $model */
                foreach ($models as $model) {
                    $seo = $model->getSeo();
                    $url = $model->getUrl();
                    $this->addSeoPageToSitemap($baseUrl.$url, $seo);
                }
            }
        }

        return $this->sitemap;
    }

    /**
     * Добавить один url в карту сайта
     * @param $url
     * @param SeoPageVm $seoPageVm
     */
    public function addSeoPageToSitemap(
        $url,
        SeoPageVm $seoPageVm
    ) {
        if ($seoPageVm->noindex) {
            return;
        }

        $buildDate = time();
        $importance = 0.3;
        $freq = 'daily';

        if ($seoPageVm->sitemap_freq) {
            $freq = $seoPageVm->sitemap_freq;
        }

        if ($seoPageVm->sitemap_importance) {
            $importance = $seoPageVm->sitemap_importance;
        }

        $this->sitemap->addItem(new SitemapItemDto($url, $buildDate, $freq, $importance));
    }
}