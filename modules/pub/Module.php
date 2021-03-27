<?php

namespace app\modules\pub;

use kosuha606\VirtualAdmin\Domains\Seo\SeoService;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualShop\ServiceManager as ShopServiceManager;
use Yii;
use yii\base\Action;

class Module extends \yii\base\Module
{
    /**
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        $this->registerMetaData();
        $cartData = Yii::$app->session->get('cart');
        ShopServiceManager::getInstance()->cartBuilder->unserialize($cartData);
        ShopServiceManager::getInstance()->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    private function registerMetaData(): void
    {
        $url = '/' . Yii::$app->request->pathInfo;
        $seoPage = ServiceManager::getInstance()->get(SeoService::class)->findSeoPageByUrl($url);
        $view = Yii::$app->controller->getView();
        $view->title = $seoPage->title;
        $view->registerMetaTag(['name' => 'keywords', 'content' => $seoPage->meta_keywords]);
        $view->registerMetaTag(['name' => 'description', 'content' => $seoPage->mata_description]);

        if ($seoPage->og_title) {
            $view->registerMetaTag(['property' => 'og:title', 'content' => $seoPage->og_title]);
        }

        if ($seoPage->og_description) {
            $view->registerMetaTag(['property' => 'og:description', 'content' => $seoPage->og_description]);
        }

        if ($seoPage->og_image) {
            $view->registerMetaTag(['property' => 'og:image', 'content' => $seoPage->og_image]);
        }

        if ($seoPage->og_type) {
            $view->registerMetaTag(['property' => 'og:type', 'content' => $seoPage->og_type]);
        }

        if ($seoPage->og_url) {
            $view->registerMetaTag(['property' => 'og:url', 'content' => $seoPage->og_url]);
        }

        if ($seoPage->noindex) {
            $view->registerMetaTag(['name' => 'robot', 'content' => 'noindex, nofollow']);
        }

        if ($seoPage->canonical) {
            $view->registerLinkTag(['rel' => 'canonical', 'href' => $seoPage->canonical]);
        }
    }
}
