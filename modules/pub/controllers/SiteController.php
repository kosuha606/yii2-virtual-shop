<?php

namespace app\modules\pub\controllers;

use app\models\Product;
use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use kosuha606\VirtualAdmin\Domains\Sitemap\SitemapVm;
use kosuha606\VirtualShop\Model\FilterCategoryVm;
use kosuha606\VirtualShop\Model\FilterProductVm;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualShop\ServiceManager;
use Yii;
use yii\base\Component;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
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
                    'logout' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions(): array
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
    public function actionIndex(): string
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

        $filters = ServiceManager::getInstance()->productService->processGetFilters(
            Yii::$app->request->get('filter')
        );

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
     * @return string
     */
    public function actionSearch(): string
    {
        return $this->render('search');
    }

    /**
     * @return string
     */
    public function actionView(): string
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
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return Response
     */
    public function actionLang()
    {
        $l = Yii::$app->request->get('l', 'ru');
        $langService = \kosuha606\VirtualModelHelppack\ServiceManager::getInstance()->get(LanguageService::class);
        $langService->setLang($l);

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @return mixed
     */
    public function actionSitemap()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        return SitemapVm::getSitemapContent();
    }
}
