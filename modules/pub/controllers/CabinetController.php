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
use yii\web\Response;

// FIXME подумать как избавиться от сервис локатора
class CabinetController extends Controller
{
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
        ServiceManager::getInstance()->cartBuilder->unserialize($cartData);
        ServiceManager::getInstance()->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    /**
     * @return string
     */
    public function actionOrders(): string
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
     */
    public function actionFavorites(): string
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
        $user = ServiceManager::getInstance()->userService->current();

        ServiceManager::getInstance()->favoriteService->deleteByProductAndUserId($productId, $user->id);
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

        $user = ServiceManager::getInstance()->userService->current();
        ServiceManager::getInstance()->favoriteService->addUserProduct($user, $product);
        Yii::$app->session->addFlash('success', 'Успешно добавлено в избранное');

        return $this->redirect(['cabinet/favorites']);
    }
}
