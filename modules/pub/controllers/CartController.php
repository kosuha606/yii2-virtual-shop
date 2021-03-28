<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualShop\Cart\CartBuilder;
use kosuha606\VirtualShop\Model\DeliveryVm;
use kosuha606\VirtualShop\Model\PaymentVm;
use kosuha606\VirtualShop\Services\OrderService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\Session;

class CartController extends Controller
{
    public const CART_SESS_KEY = 'cart';
    private CartBuilder $cartBuilder;
    private UserService $userService;
    private Session $session;
    private OrderService $orderService;

    /**
     * @param $id
     * @param $module
     * @param CartBuilder $cartBuilder
     * @param UserService $userService
     * @param OrderService $orderService
     * @param Session $session
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        CartBuilder $cartBuilder,
        UserService $userService,
        OrderService $orderService,
        Session $session,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->cartBuilder = $cartBuilder;
        $this->userService = $userService;
        $this->session = $session;
        $this->orderService = $orderService;
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
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
     */
    public function beforeAction($action): bool
    {
        $cartData = $this->session->get(self::CART_SESS_KEY);
        $this->cartBuilder->unserialize($cartData);
        $this->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        if ($this->request->isPost) {
            $productId = $this->request->post('product_id');
            $qty = $this->request->post('qty');
            $this->cartBuilder->addProductById($productId, $qty);
            $this->session->set(self::CART_SESS_KEY, $this->cartBuilder->serialize());
            $this->session->addFlash('success', 'Успешно добавлено в корзину');

            return $this->goHome();
        }

        $cart = $this->cartBuilder->getCart();
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
     * @return string|Response
     */
    public function actionCheckout()
    {
        $promocode = $this->request->post('promocode');
        $paymentId = $this->request->post('payment_id');
        $deliveryId = $this->request->post('delivery_id');

        if (!$paymentId) {
            $this->session->addFlash('error', 'Необходимо указать способ оплаты');

            return $this->redirect(['/cart/index']);
        }

        if (!$deliveryId) {
            $this->session->addFlash('error', 'Необходимо указать способ доставки');

            return $this->redirect(['/cart/index']);
        }

        $cartBuilder = $this->cartBuilder;
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
     */
    public function actionComplete(): string
    {
        $this->session->set(self::CART_SESS_KEY, null);
        $cartBuilder = $this->cartBuilder;
        $cartData = [];

        if ($cartBuilder->getCart()->hasItems()) {
            $cartData = $this->request->post('cart_data');
            $cartBuilder->clear();
            $cartBuilder->unserialize(json_decode($cartData, true));
            $cart = $cartBuilder->getCart();
            $user = $this->userService->current();
            $this->orderService->buildOrder($cart, $user);
        }

        return $this->render('complete', [
            'cartData' => $cartData,
            'cart' => $cartBuilder->getCart(),
        ]);
    }

    /**
     * @return Response
     */
    public function actionDelete(): Response
    {
        $id = $this->request->get('id');
        $this->cartBuilder->deleteProductById($id);
        $this->session->set(self::CART_SESS_KEY, $this->cartBuilder->serialize());
        $this->session->addFlash('success', 'Успешно удалено из корзины');

        return $this->redirect(['/cart/index']);
    }

    /**
     * @return Response
     */
    public function actionClearall(): Response
    {
        $this->cartBuilder->clear();
        $this->session->set(self::CART_SESS_KEY, $this->cartBuilder->serialize());
        $this->session->addFlash('success', 'Из корзины удалены все товары');

        return $this->redirect(['cart/index']);
    }
}
