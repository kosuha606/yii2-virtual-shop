<?php

namespace app\modules\pub;

use kosuha606\VirtualAdmin\Domains\Seo\SeoService;
use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualShop\Cart\CartBuilder;
use Yii;
use yii\base\Action;
use yii\web\Application;
use yii\web\Session;

class Module extends \yii\base\Module
{
    private CartBuilder $cartBuilder;
    private UserService $userService;
    private Session $session;
    private SeoService $seoService;

    /**
     * @param $id
     * @param Application $parent
     * @param CartBuilder $cartBuilder
     * @param UserService $userService
     * @param SeoService $seoService
     * @param Session $session
     * @param array $config
     */
    public function __construct(
        $id,
        $parent,
        CartBuilder $cartBuilder,
        UserService $userService,
        SeoService $seoService,
        Session $session,
        $config = []
    ) {
        parent::__construct($id, $parent, $config);
        $this->cartBuilder = $cartBuilder;
        $this->userService = $userService;
        $this->session = $session;
        $this->seoService = $seoService;
    }

    /**
     * @param Action $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        $this->registerMetaData();
        $cartData = $this->session->get('cart');
        $this->cartBuilder->unserialize($cartData);
        $this->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    private function registerMetaData(): void
    {
        $url = '/' . $this->request->pathInfo;
        $seoPage = $this->seoService->findSeoPageByUrl($url);
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
