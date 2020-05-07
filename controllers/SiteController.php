<?php

namespace app\controllers;

use app\models\FilterProduct;
use app\virtualModels\Model\FilterCategoryVm;
use app\virtualModels\Model\FilterProductVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\ServiceManager;
use kosuha606\VirtualModel\VirtualModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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
     * Displays homepage.
     *
     * @return string
     * @throws \Exception
     */
    public function actionIndex()
    {
        $page = Yii::$app->request->get('page');
        $order = Yii::$app->request->get('order');

        $filtersData = [];
        /** @var FilterCategoryVm[] $filterCategories */
        $filterCategories = FilterCategoryVm::many(['where' => [['all']]]);

        foreach ($filterCategories as $filterCategory) {
            $filtersData[$filterCategory->name] = FilterProductVm::many([
                'select' => 'category_id, value',
                'where' => [['=', 'category_id', $filterCategory->id]],
                'groupBy' => 'value, category_id',
            ]);
        }

        $filters = [];

        // @TODO Вынести применение фильтро в отдельный метод и написать тесты
        if ($filtersGet = Yii::$app->request->get('filter')) {
            $filters['id'] = [];
            $filterProducts = [];
            foreach ($filtersGet as $item) {
                list($value, $categoryId) = explode('_', $item);
                $nextFilterProducts = $this->getProductIds(FilterProductVm::many([
                    'where' => [
                        ['=', 'value', $value],
                        ['=', 'category_id', $categoryId],
                    ],
                ]));

                if (isset($filterProducts[$categoryId])) {
                    $filterProducts[$categoryId] = array_merge($filterProducts[$categoryId], $nextFilterProducts);
                } else {
                    $filterProducts[$categoryId] = $nextFilterProducts;
                }
            }

            foreach ($filterProducts as $filterProduct) {
                if (!$filters['id']) {
                    $filters['id'] = $filterProduct;
                } else {
                    $filters['id'] = array_intersect($filters['id'], $filterProduct);
                }
            }
        }

        $dto = ServiceManager::getInstance()->productService->loadProductsWithActions(
            $filters,
            $page,
            6,
            $order
        );

        return $this->render('index', [
            'products' => $dto->products,
            'pagination' => $dto->pagination,
            'filtersData' => $filtersData,
        ]);
    }

    /**
     * @param FilterProductVm[] $items
     * @return array
     */
    private function getProductIds($items)
    {
        $result = [];

        foreach ($items as $item) {
            $result[] = $item->product_id;
        }

        return $result;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        $product = ProductVm::one([
            'where' => [
                ['=', 'id', $id],
            ],
        ]);

        return $this->render('view', [
            'product' => $product,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
