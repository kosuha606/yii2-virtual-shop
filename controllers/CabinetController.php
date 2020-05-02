<?php

namespace app\controllers;

use app\virtualModels\ServiceManager;
use Yii;
use yii\web\Controller;

class CabinetController extends Controller
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

        return parent::beforeAction($action);
    }

    public function actionOrders()
    {
        return $this->render('orders');
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