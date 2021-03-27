<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\Seo\SeoFilterService;
use kosuha606\VirtualShop\Model\CategoryVm;
use kosuha606\VirtualShop\ServiceManager;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class CategoryController extends Controller
{
    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        $cartData = Yii::$app->session->get('cart');
        ServiceManager::getInstance()->cartBuilder->unserialize($cartData);
        ServiceManager::getInstance()->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionCategory(): string
    {
        $id = Yii::$app->request->get('id');
        $category = CategoryVm::one([
            'where' => [
                ['=', 'id', $id],
            ],
        ]);

        return $this->render('view', [
            'category' => $category,
        ]);
    }

    /**
     * @return Response
     */
    public function actionFilter(): Response
    {
        $filters = Yii::$app->request->post('filter', []);
        $seoFilterService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(SeoFilterService::class);
        $url = $seoFilterService->createUrl($filters);
        $referer = Yii::$app->request->referrer;

        if ($url) {
            $referer = rtrim($referer, '/');
            $refererParts = explode('/filter-', $referer);
            return $this->redirect($refererParts[0].'/filter-'.$url);
        }

        return $this->redirect($referer.'?'.http_build_query([
            'filter' => $filters
        ]));
    }
}
