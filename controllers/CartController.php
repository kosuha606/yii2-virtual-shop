<?php

namespace app\controllers;

use app\virtualModels\Model\DeliveryVm;
use app\virtualModels\Model\PaymentVm;
use app\virtualModels\ServiceManager;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;

class CartController extends Controller
{
    const CART_SESS_KEY = 'cart';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'checkout' => ['post'],
                    'complete' => ['post'],
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
        $cartData = Yii::$app->session->get(self::CART_SESS_KEY);
        ServiceManager::getInstance()->cartBuilder->unserialize($cartData);

        return parent::beforeAction($action);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            $productId = Yii::$app->request->post('product_id');
            $qty = Yii::$app->request->post('qty');
            ServiceManager::getInstance()->cartBuilder->addProductById($productId, $qty);
            Yii::$app->session->set(self::CART_SESS_KEY, ServiceManager::getInstance()->cartBuilder->serialize());
            Yii::$app->session->addFlash('success', 'Успешно добавлено в корзину');

            return $this->redirect(['/cart/index']);
        }
        $cart = ServiceManager::getInstance()->cartBuilder->getCart();
        $deliveries = DeliveryVm::many([
            'where' => ['all']
        ]);
        $payments = PaymentVm::many([
            'where' => ['all']
        ]);

        return $this->render('index', [
            'cart' => $cart,
            'deliveries' => $deliveries,
            'payments' => $payments,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCheckout()
    {
        $promocode = Yii::$app->request->post('promocode');
        $paymentId = Yii::$app->request->post('payment_id');
        $deliveryId = Yii::$app->request->post('delivery_id');

        if (!$paymentId) {
            Yii::$app->session->addFlash('error', 'Необходимо указать способ оплаты');
            return $this->redirect(['/cart/index']);
        }

        if (!$deliveryId) {
            Yii::$app->session->addFlash('error', 'Необходимо указать способ доставки');
            return $this->redirect(['/cart/index']);
        }

        $cartBuilder = ServiceManager::getInstance()->cartBuilder;
        $cartBuilder->setDeliveryById($deliveryId);
        $cartBuilder->setPaymentById($paymentId);

        if ($promocode) {
            $cartBuilder->setPromocodeByCode($promocode);
        }

        return $this->render('checkout', [
            'cart' => $cartBuilder->getCart()
        ]);
    }

    public function actionComplete()
    {
        Yii::$app->session->set(self::CART_SESS_KEY, null);
        $cartBuilder = ServiceManager::getInstance()->cartBuilder;
        $cartData = [];

        if ($cartBuilder->getCart()->hasItems()) {
            // TODO создание заказа
            $cartData = Yii::$app->request->post('cart_data');
        }

        return $this->render('complete', [
            'cartData' => $cartData,
            'cart' => $cartBuilder->getCart(),
        ]);
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        ServiceManager::getInstance()->cartBuilder->deleteProductById($id);
        Yii::$app->session->set(self::CART_SESS_KEY, ServiceManager::getInstance()->cartBuilder->serialize());
        Yii::$app->session->addFlash('success', 'Успешно удалено из корзину');

        return $this->redirect(['/cart/index']);
    }
}