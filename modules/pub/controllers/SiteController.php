<?php

namespace app\modules\pub\controllers;

use kosuha606\VirtualAdmin\Domains\Multilang\LanguageService;
use kosuha606\VirtualAdmin\Domains\Sitemap\SitemapVm;
use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualShop\Cart\CartBuilder;
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
    private CartBuilder $cartBuilder;
    private UserService $userService;
    private ProductService $productService;

    /**
     * @param $id
     * @param $module
     * @param LanguageService $languageService
     * @param CartBuilder $cartBuilder
     * @param UserService $userService
     * @param ProductService $productService
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        LanguageService $languageService,
        CartBuilder $cartBuilder,
        UserService $userService,
        ProductService $productService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->languageService = $languageService;
        $this->cartBuilder = $cartBuilder;
        $this->userService = $userService;
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
    public function actionLang()
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
