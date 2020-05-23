<?php

namespace app\controllers;

use app\virtualModels\Admin\Dto\AdminResponseDTO;
use app\virtualModels\Admin\Interfaces\AdminControllerInterface;
use app\virtualModels\Admin\Processors\AdminRequestProcessor;
use app\virtualModels\Controllers\CrudController;
use app\virtualModels\Services\UserService;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\web\Controller;
use Yii;

class AdminController extends Controller implements AdminControllerInterface
{
    public $layout = 'admin';

    public $menu = [];

    /**
     * @param $action
     * @return bool
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        ServiceManager::getInstance()->get(UserService::class)->login(Yii::$app->user->id);

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->redirect('/admin/order/list');
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionProcessor()
    {
        $controller = Yii::$app->request->get('route');
        $action = Yii::$app->request->get('act');

        $post = Yii::$app->request->post();
        $delete = false;

        if (isset($post['delete'])) {
            $delete = $post['delete'];
            unset($post['delete']);
        }

        $requestData = [
            'get' => Yii::$app->request->get(),
            'post' => $post,
            'delete' => $delete,
        ];

        if (Yii::$app->request->get('sortField')) {
            $requestData['get']['order'] = [
                Yii::$app->request->get('sortField') => Yii::$app->request->get('sortDir') == 'desc' ? SORT_DESC : SORT_ASC,
            ];
        }

        $processor = ServiceManager::getInstance()->get(AdminRequestProcessor::class);
        $processor->loadConfig(__DIR__.'/../config/routes');
        $processor->setController($this);

        $response = new AdminResponseDTO('', []);
        try {
            $response = $processor->process($controller, $action, $requestData);
        } catch (\Exception $exception) {
            $response->json['result'] = false;
            $response->json['errors'][] = $exception->getMessage();
        }
        $this->menu = $processor->getMenu();

        if (Yii::$app->request->isAjax) {
            return $this->asJson($response->json);
        }

        return $this->render('processor', [
            'response' => $response
        ]);
    }

    public function renderView($view, $args)
    {
        return $this->renderPartial($view, $args);
    }
}