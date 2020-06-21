<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualShop\Model\FavoriteVm;
use kosuha606\VirtualShop\Model\OrderVm;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualShop\ServiceManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * @package app\modules\pub\controllers
 */
class CabinetController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'add-favorite' => ['post'],
                    'delete-favorite' => ['post'],
                ],
            ],
        ];
    }

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

    /**
     * @return string
     * @throws \Exception
     */
    public function actionOrders()
    {
        $user = ServiceManager::getInstance()->userService->current();
        $orders = OrderVm::many([
            'where' => [
                ['=', 'user_id', $user->id]
            ],
            'orderBy' => ['id' => SORT_DESC]
        ]);

        return $this->render('orders', [
            'orders' => $orders
        ]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionFavorites()
    {
        $user = ServiceManager::getInstance()->userService->current();
        $favorites = FavoriteVm::many([
            'where' => [
                ['=', 'user_id', $user->id]
            ]
        ]);

        return $this->render('favorites', [
            'favorites' => $favorites
        ]);
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }

    /**
     * @throws \Exception
     */
    public function actionDeleteFavorite()
    {
        $productId = Yii::$app->request->post('product_id');
        $user = ServiceManager::getInstance()->userService->current();

        ServiceManager::getInstance()->favoriteService->deleteByProductAndUserId($productId, $user->id);
        Yii::$app->session->addFlash('success', 'Успешно удалено');

        return $this->redirect(['cabinet/favorites']);
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionAddFavorite()
    {
        $productId = Yii::$app->request->post('product_id');
        $product = ProductVm::one([
            'where' => [
                ['=', 'id', $productId]
            ]
        ]);

        $user = ServiceManager::getInstance()->userService->current();
        ServiceManager::getInstance()->favoriteService->addUserProduct($user, $product);
        Yii::$app->session->addFlash('success', 'Успешно добавлено в избранное');

        return $this->redirect(['cabinet/favorites']);
    }
}