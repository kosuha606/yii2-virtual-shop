<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\Seo\SeoFilterService;
use kosuha606\VirtualShop\Model\CategoryVm;
use kosuha606\VirtualShop\ServiceManager;
use Yii;
use yii\web\Controller;

class CategoryController extends Controller
{
    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * @throws \Exception
     */
    public function beforeAction($action)
    {
        $cartData = Yii::$app->session->get('cart');
        ServiceManager::getInstance()->cartBuilder->unserialize($cartData);
        ServiceManager::getInstance()->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

    }

    public function actionCategory()
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
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public function actionFilter()
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