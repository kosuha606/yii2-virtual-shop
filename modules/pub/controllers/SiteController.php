<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use kosuha606\VirtualAdmin\Domains\Sitemap\SitemapVm;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualShop\Services\ProductService;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    private LanguageService $languageService;
    private ProductService $productService;

    /**
     * @param $id
     * @param $module
     * @param LanguageService $languageService
     * @param ProductService $productService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        LanguageService $languageService,
        ProductService $productService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->languageService = $languageService;
        $this->productService = $productService;
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class' => VerbFilter::class,
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
     * @return string
     */
    public function actionIndex(): string
    {
        $page = $this->request->get('page');
        $order = $this->request->get('order');

        $filters = $this->productService->processGetFilters(
            Yii::$app->request->get('filter')
        );

        $dto = $this->productService->loadProductsWithActions(
            $filters,
            $page,
            6,
            $order
        );

        return $this->render('index', [
            'pagination' => $dto->pagination,
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
        $id = $this->request->get('id');
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
    public function actionLang(): Response
    {
        $l = $this->request->get('l', 'ru');
        $langService = $this->languageService;
        $langService->setLang($l);

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @return mixed
     */
    public function actionSitemap()
    {
        $this->response->format = Response::FORMAT_RAW;
        $this->response->headers->add('Content-Type', 'text/xml');

        return SitemapVm::getSitemapContent();
    }
}
