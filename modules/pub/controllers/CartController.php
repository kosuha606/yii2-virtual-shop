<?php

namespace app\modules\pub\controllers;

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

        ServiceManager::getInstance()->userService->login(Yii::$app->user->id);

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

            return $this->goHome();
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

    /**
     * @return string
     * @throws \Exception
     */
    public function actionComplete()
    {
        Yii::$app->session->set(self::CART_SESS_KEY, null);
        $cartBuilder = ServiceManager::getInstance()->cartBuilder;
        $cartData = [];

        if ($cartBuilder->getCart()->hasItems()) {
            $cartData = Yii::$app->request->post('cart_data');
            $cartBuilder->clear();
            $cartBuilder->unserialize(json_decode($cartData, true));
            $cart = $cartBuilder->getCart();
            $user = ServiceManager::getInstance()->userService->current();
            ServiceManager::getInstance()->orderService->buildOrder($cart, $user);
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
        Yii::$app->session->addFlash('success', 'Успешно удалено из корзины');

        return $this->redirect(['/cart/index']);
    }

    public function actionClearall()
    {
        ServiceManager::getInstance()->cartBuilder->clear();
        Yii::$app->session->set(self::CART_SESS_KEY, ServiceManager::getInstance()->cartBuilder->serialize());
        Yii::$app->session->addFlash('success', 'Из корзины удалены все товары');

        return $this->redirect(['cart/index']);
    }
}