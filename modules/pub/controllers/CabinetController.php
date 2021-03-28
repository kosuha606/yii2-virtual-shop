<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualShop\Cart\CartBuilder;
use kosuha606\VirtualShop\Model\FavoriteVm;
use kosuha606\VirtualShop\Model\OrderVm;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualShop\Services\FavoriteService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class CabinetController extends Controller
{
    private UserService $userService;
    private CartBuilder $cartBuilder;
    private FavoriteService $favoriteService;

    /**
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param CartBuilder $cartBuilder
     * @param FavoriteService $favoriteService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        UserService $userService,
        CartBuilder $cartBuilder,
        FavoriteService $favoriteService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->cartBuilder = $cartBuilder;
        $this->favoriteService = $favoriteService;
    }

    /**
     * @return array[]
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
     */
    public function beforeAction($action): bool
    {
        $cartData = Yii::$app->session->get('cart');
        $this->cartBuilder->unserialize($cartData);
        $this->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionOrders(): string
    {
        $user = $this->userService->current();
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
     */
    public function actionFavorites(): string
    {
        $user = $this->userService->current();
        $favorites = FavoriteVm::many([
            'where' => [
                ['=', 'user_id', $user->id]
            ]
        ]);

        return $this->render('favorites', [
            'favorites' => $favorites
        ]);
    }

    /**
     * @return string
     */
    public function actionProfile(): string
    {
        return $this->render('profile');
    }

    /**
     * @return Response
     */
    public function actionDeleteFavorite(): Response
    {
        $productId = Yii::$app->request->post('product_id');
        $user = $this->userService->current();

        $this->favoriteService->deleteByProductAndUserId($productId, $user->id);
        Yii::$app->session->addFlash('success', 'Успешно удалено');

        return $this->redirect(['cabinet/favorites']);
    }

    /**
     * @return Response
     */
    public function actionAddFavorite(): Response
    {
        $productId = Yii::$app->request->post('product_id');
        $product = ProductVm::one([
            'where' => [
                ['=', 'id', $productId]
            ]
        ]);

        $user = $this->userService->current();
        $this->favoriteService->addUserProduct($user, $product);
        Yii::$app->session->addFlash('success', 'Успешно добавлено в избранное');

        return $this->redirect(['cabinet/favorites']);
    }
}
