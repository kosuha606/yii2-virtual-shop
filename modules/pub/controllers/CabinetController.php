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
use yii\web\Session;

class CabinetController extends Controller
{
    private UserService $userService;
    private CartBuilder $cartBuilder;
    private FavoriteService $favoriteService;
    private Session $session;

    /**
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param CartBuilder $cartBuilder
     * @param FavoriteService $favoriteService
     * @param Session $session
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        UserService $userService,
        CartBuilder $cartBuilder,
        FavoriteService $favoriteService,
        Session $session,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->cartBuilder = $cartBuilder;
        $this->favoriteService = $favoriteService;
        $this->session = $session;
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
        $this->session->addFlash('success', 'Успешно удалено');

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
        $this->session->addFlash('success', 'Успешно добавлено в избранное');

        return $this->redirect(['cabinet/favorites']);
    }
}
