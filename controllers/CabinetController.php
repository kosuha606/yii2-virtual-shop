<?php

namespace app\controllers;

use app\virtualModels\Model\OrderVm;
use app\virtualModels\ServiceManager;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

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

    public function actionFavorites()
    {
        return $this->render('favorites');
    }

    public function actionProfile()
    {
        return $this->render('profile');
    }
}