<?php

namespace app\controllers;

use app\virtual\AppRoutesLoader;
use Exception;
use kosuha606\VirtualAdmin\Classes\AdminDefaultRoutesLoader;
use kosuha606\VirtualAdmin\Domains\User\UserService;
use kosuha606\VirtualAdmin\Domains\Version\VersionService;
use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use kosuha606\VirtualAdmin\Interfaces\AdminControllerInterface;
use kosuha606\VirtualAdmin\Processors\AdminRequestProcessor;
use kosuha606\VirtualContent\ContentRoutesLoader;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualShop\ShopRoutesLoader;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class AdminController extends Controller implements AdminControllerInterface
{
    public array $menu = [];
    private UserService $userService;
    private AdminRequestProcessor $adminRequestProcessor;

    /**
     * @param $id
     * @param $module
     * @param UserService $userService
     * @param AdminRequestProcessor $adminRequestProcessor
     * @param array $config
     */
    public function __construct(
        $id,
        $module,
        UserService $userService,
        AdminRequestProcessor $adminRequestProcessor,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->adminRequestProcessor = $adminRequestProcessor;
        $this->enableCsrfValidation = false;
        $this->layout = 'admin';
    }

    /**
     * @param $action
     * @return bool
     */
    public function beforeAction($action): bool
    {
        $this->userService->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    /**
     * @return Response
     */
    public function actionIndex(): Response
    {
        return $this->redirect('/admin/order/list');
    }

    /**
     * @return string
     */
    public function actionProcessor(): string
    {
        $controller = $this->request->get('route');
        $action = $this->request->get('act');

        $post = $this->request->post();
        $delete = false;

        if (isset($post['delete'])) {
            $delete = $post['delete'];
            unset($post['delete']);
        }

        $requestData = [
            'get' => $this->request->get(),
            'post' => $post,
            'delete' => $delete,
        ];

        if ($this->request->get('sortField')) {
            $requestData['get']['order'] = [
                $this->request->get('sortField') => $this->request->get('sortDir') == 'desc' ? SORT_DESC : SORT_ASC,
            ];
        }

        $processor = $this->adminRequestProcessor;
        $processor
            ->addRoutesLoader(new AppRoutesLoader())
            ->addRoutesLoader(new ContentRoutesLoader())
            ->addRoutesLoader(new ShopRoutesLoader())
            ->addRoutesLoader(new AdminDefaultRoutesLoader())
        ;
        $processor->loadConfig(null, function($config) {
            unset($config['routes']['article']);
            unset($config['routes']['article_category']);

            return $config;
        });
        $processor->setController($this);
        $response = new AdminResponseDTO('', []);

        try {
            $response = $processor->process($controller, $action, $requestData);
        } catch (Exception $exception) {
            $response->json['result'] = false;
            $response->json['errors'][] = $exception->getMessage();

            if (!$this->request->isAjax) {
                throw $exception;
            }
        }

        $this->menu = $processor->getMenu();

        if ($this->request->isAjax) {
            return $this->asJson($response->json);
        }

        $this->handleAlerts();

        return $this->render('processor', [
            'response' => $response
        ]);
    }

    private function handleAlerts(): void
    {
        $alerts = Yii::$app->session->getAllFlashes(true);
        $this->getView()->registerJsVar('_alerts', $alerts);
    }

    /**
     * @return Response
     */
    public function actionVersionRestore(): Response
    {
        $result = [
            'result' => true,
        ];
        $id = Yii::$app->request->post('id');
        $versionService = ServiceManager::getInstance()->get(VersionService::class);
        $versionService->restoreById($id);

        return $this->asJson($result);
    }

    /**
     * @param $view
     * @param $args
     * @return string
     */
    public function renderView($view, $args): string
    {
        return $this->renderPartial($view, $args);
    }
}