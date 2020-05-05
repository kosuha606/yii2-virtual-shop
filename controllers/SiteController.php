<?php

namespace app\controllers;

use app\virtualModels\Model\ProductVm;
use app\virtualModels\ServiceManager;
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

        $dto = ServiceManager::getInstance()->productService->loadProductsWithActions(
            [],
            $page,
            6,
            $order
        );

        return $this->render('index', [
            'products' => $dto->products,
            'pagination' => $dto->pagination
        ]);
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
                ['=', 'id', $id]
            ]
        ]);

        return $this->render('view', [
            'product' => $product
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
