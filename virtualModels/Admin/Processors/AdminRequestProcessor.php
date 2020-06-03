<?php

namespace app\virtualModels\Admin\Processors;

use app\virtualModels\Admin\Dto\AdminResponseDTO;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Admin\Interfaces\AdminControllerInterface;
use app\virtualModels\Admin\Services\AdminConfigService;
use app\virtualModels\Admin\Services\AlertService;
use app\virtualModels\Admin\Services\MenuService;
use app\virtualModels\Admin\Services\PermissionService;
use app\virtualModels\Classes\Pagination;
use app\virtualModels\Controllers\CrudController;
use app\virtualModels\Services\UserService;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ValidatableVirtualModel;

/**
 * @description Обработчик запросов к админке
 * @description Настройки роутов загружаются из конфигов в папке
 */
class AdminRequestProcessor
{
    /**
     * @var AdminConfigService
     */
    private $adminConfigService;

    private $config = null;

    /** @var AdminControllerInterface */
    private $controller;

    /**
     * @var MenuService
     */
    private $menuService;

    /**
     * @var CrudController
     */
    private $crudController;

    /**
     * @var AlertService
     */
    private $alertService;

    /**
     * @var PermissionService
     */
    private $permissionService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var SecondaryFormService
     */
    private $secondaryFormService;

    public function __construct(
        AdminConfigService $adminConfigService,
        MenuService $menuService,
        CrudController $crudController,
        AlertService $alertService,
        PermissionService $permissionService,
        UserService $userService,
        SecondaryFormService $secondaryFormService
    ) {
        $this->adminConfigService = $adminConfigService;
        $this->menuService = $menuService;
        $this->crudController = $crudController;
        $this->alertService = $alertService;
        $this->permissionService = $permissionService;
        $this->userService = $userService;
        $this->secondaryFormService = $secondaryFormService;
    }

    /**
     * Обработка запроса с учетом сложной формы
     * @param $controller
     * @param $action
     * @param array $requestData
     * @return AdminResponseDTO
     * @throws \Exception
     */
    public function processComplexForm($controller, $action, $requestData = [])
    {
        if (
            isset($requestData['post']) &&
            $this->isComplexFormArray($requestData['post'])
        ) {
            foreach ($requestData['post'] as $forms) {
                foreach ($forms as $form) {
                    $formRequest = $requestData;
                    $formRequest['post'] = $form;
                    $response = $this->process($controller, $action, $formRequest);
                }
            }

            return $response;
        }

        return $this->process($controller, $action, $requestData);
    }

    /**
     * @description Основной код обработки запроса на действие
     *
     * @param $controller
     * @param $action
     * @param [] $requestData
     * @return AdminResponseDTO
     * @throws \Exception
     */
    public function process($controller, $action, $requestData = []): AdminResponseDTO
    {
        $user = $this->userService->current();
        $this->permissionService->ensureActionAvailable('admin.access', $user);
        $this->ensureConfigCorrect($controller, $action);

        $this->secondaryFormService->processRememberedForm();

        $handler = $this->config['routes'][$controller][$action]['handler'];
        $response = new AdminResponseDTO('', []);
        $requestData = [
            'get' => $requestData['get'] ?? [],
            'post' => $requestData['post'] ?? [],
            'delete' => $requestData['delete'] ?? [],
        ];

        // Если хэндлер - колбэк, вызываем его
        if (is_callable($handler)) {
            $handlerResponse = $handler($this->getController());

            if (!$handlerResponse instanceof AdminResponseDTO) {
                throw new \Exception('Handler must return AdminResponseDTO');
            }

            $response = $handlerResponse;
        }

        // Если хэндлер - массив, рендерим вид по названию действия
        if (is_array($handler)) {

            if (isset($handler['crud'])) {
                $crudModel = $handler['crud']['model'];
                $crudAction = $handler['crud']['action'];
                $id = $requestData['get']['id'] ?? null;

                $this->permissionService->ensureEntityTypeAvailable($crudModel, $user);

                if (!$id) {
                    $id = $requestData['post']['id'] ?? null;
                }

                switch ($crudAction) {
                    case 'actionList':
                        $defaultOrder = isset($handler['crud']['orderBy']) ?
                            [$handler['crud']['orderBy']['field'] => $handler['crud']['orderBy']['direction']]
                            : [];
                        $filter = $requestData['get']['filter'] ?? [];
                        $order = $requestData['get']['order'] ?? $defaultOrder;
                        $page  = $requestData['get']['page'] ?? 1;
                        $itemPerPage = $requestData['get']['itemPerPage'] ?? 10;
                        $pagination = new Pagination($page, $itemPerPage);

                        if (isset($handler['filter']) && is_callable($handler['filter'])) {
                            $filterCallback = $handler['filter'];
                            $resultFilter = [];

                            foreach ($filter as $filterKey => $filterValue) {
                                $function = $filterCallback($filterKey);
                                $resultFilter[] = [$function, $filterKey, $filterValue];
                            }

                            $filter = $resultFilter;
                        } else {
                            $resultFilter = [];

                            foreach ($filter as $filterKey => $filterValue) {
                                $resultFilter[] = ['=', $filterKey, $filterValue];
                            }

                            $filter = $resultFilter;
                        }

                        $response->json['models'] = VirtualModel::allToArray($this->crudController->actionList(
                            $crudModel,
                            $pagination,
                            $filter,
                            $order
                        ));

                        if (isset($handler['crud']['orderBy'])) {
                            $response->json['defaultSort'] = $handler['crud']['orderBy'];
                        }

                        $response->json['pagination'] = $pagination;
                        break;
                    case 'actionView':
                        $model = $this->crudController->actionView(
                            $crudModel,
                            $id,
                            $requestData['post']
                        );
                        $handler['item'] = $model;
                        $successMessage = null;

                        $this->permissionService->ensureEntityAvailable($model, $user);

                        if (!empty($requestData['post'])) {
                            if ($model instanceof ValidatableVirtualModel && !$model->validate()->isValid()) {
                                $response->json['result'] = false;
                                $response->json['errors'] = $model->getErrors();
                                $this->alertService->error('Не удалось выполнить сохранение');
                            } else {
                                $successMessage = 'Успешно сохранено';
                            }
                        }

                        foreach ($handler as &$handlerItem) {
                            if (is_callable($handlerItem)) {
                                $handlerItem = $handlerItem($model);
                            }
                        }

                        if (!empty($requestData['delete'])) {
                            $model->delete();
                            $response->json['model'] = null;
                            $successMessage = 'Успешно удалено';
                        } else {
                            $response->json['model'] = $model->toArray();
                        }

                        if ($successMessage) {
                            $this->alertService->success($successMessage);
                        }

                        break;
                }
            }

            $response->jsVars = array_merge($response->json, $handler);
            $response->html = $this->getController()->renderView($action, $handler);
        }

        return $response;
    }

    /**
     * @description Проверка того что объект правильно сконфигурирован
     *
     * @throws \Exception
     */
    public function ensureConfigCorrect($controller, $action)
    {
        if (!$this->controller) {
            throw new \Exception('Controler must be defined in AdminRequestProcessor');
        }

        if (!$this->config) {
            throw new \Exception('Config must be set to AdminRequestProcessor');
        }

        if (!isset($this->config['routes'])) {
            throw new \Exception('Config must have routes');
        }

        if (!isset($this->config['routes'][$controller])) {
            throw new \Exception("No such controller $controller in config");
        }

        if (!isset($this->config['routes'][$controller][$action])) {
            throw new \Exception("No such action $action in controller $controller");
        }

        if (!isset($this->config['routes'][$controller][$action]['handler'])) {
            throw new \Exception("No handler definition in config for controller $controller and action $action");
        }
    }

    /**
     * @return null
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param null $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @param $dir
     */
    public function loadConfig($dir)
    {
        $this->setConfig($this->adminConfigService->loadConfigs($dir));
        $this->menuService->processConfig($this->getConfig());
    }

    /**
     * @return AdminControllerInterface
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param AdminControllerInterface $controller
     */
    public function setController(AdminControllerInterface $controller)
    {
        $this->controller = $controller;
    }

    public function getMenu()
    {
        return $this->menuService->getMenu();
    }

    /**
     * Определяет является ли массив массивом данных от сложной формы
     * @param $array
     * @return bool
     */
    private function isComplexFormArray($array)
    {
        foreach ($array as $items) {
            if (is_array($items)) {
                foreach ($items as $item) {
                    if (is_array($item)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }

        return false;
    }
}