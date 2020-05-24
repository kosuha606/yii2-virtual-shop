<?php

use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Admin\Model\Request;
use app\virtualModels\Admin\Model\Session;
use app\virtualModels\Admin\Services\RequestService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Test\TestRequestProvider;
use app\virtualModels\Admin\Test\TestSessionProvider;
use app\virtualModels\Domains\Comment\Models\CommentVm;
use app\virtualModels\Model\ProductRestsVm;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualModelHelppack\Test\VirtualTestCase;
use PHPUnit\Framework\TestCase;

class SecondaryFormManyTest extends VirtualTestCase
{
    /** @var TestSessionProvider */
    public $sessionProvider;

    /** @var TestRequestProvider */
    public $requestProvider;

    public function setUp()
    {
        parent::setUp();
        $this->provider->memoryStorage = [
            CommentVm::class => [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'model_id' => 1,
                    'model_class' => ProductVm::class,
                    'content' => 'Hello',
                ],
                [
                    'id' => 2,
                    'user_id' => 2,
                    'model_id' => 1,
                    'model_class' => ProductVm::class,
                    'content' => 'World',
                ],
            ],
            ProductVm::class => [
                [
                    'id' => 1,
                    'name' => 'Первый',
                    'price' => 100,
                    'price2B' => 200,
                ],
                [
                    'id' => 2,
                    'name' => 'Второй',
                    'price' => 200,
                    'price2B' => 300,
                ],
            ]
        ];

        $this->sessionProvider = new TestSessionProvider();
        $this->requestProvider = new TestRequestProvider();

        VirtualModelManager::getInstance()->setProvider($this->sessionProvider);
        VirtualModelManager::getInstance()->setProvider($this->requestProvider);
    }

    public function tearDown()
    {
        RequestService::$request = null;
        unset($this->sessionProvider);
        unset($this->requestProvider);
        parent::tearDown();
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public function testMultiProcess()
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);
        // Устанавливаем состояние сессии
        $this->sessionProvider->memoryStorage = [
            Session::class => [
                [
                    'id' => 0,
                    'key' => 'secondary_form',
                    'value' => [
                        CommentVm::class => [
                            'masterModelId' => '1,'.ProductVm::class,
                            'masterModelField' => 'model_id,model_class',
                            'masterModelClass' => ProductVm::class,
                            'relationType' => SecondaryFormBuilder::ONE_TO_MANY
                        ]
                    ]
                ]
            ]
        ];

        $this->requestProvider->memoryStorage = [
            Request::class => [
                [
                    'get' => [],
                    'post' => [
                        'secondary_form' => [
                            CommentVm::class => [
                                [
                                    'user_id' => 1,
                                    'model_id' => 1,
                                    'model_class' => ProductVm::class,
                                    'content' => 'Hello',
                                ],
                                [
                                    'user_id' => 2,
                                    'model_id' => 1,
                                    'model_class' => ProductVm::class,
                                    'content' => 'World',
                                ],
                            ]
                        ]
                    ],
                    'isAjax' => false,
                    'isPost' => true,
                ]
            ]
        ];

        $secondaryService->processRememberedForm();

        $this->assertEquals(2, count($this->provider->memoryStorage[CommentVm::class]));
    }

}