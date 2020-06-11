<?php

use app\virtualModels\Admin\Test\TestCacheProvider;
use app\virtualModels\Admin\Test\TestSearchProvider;
use app\virtualModels\Admin\Test\TestTransactionProvider;
use app\virtualModels\Classes\Pagination;
use app\virtualModels\Controllers\CrudController;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use kosuha606\VirtualModel\VirtualModelManager;
use PHPUnit\Framework\TestCase;

class CrudControllerTest extends TestCase
{
    /** @var MemoryModelProvider  */
    private $provider;

    /** @var CrudController */
    private $controller;

    public function setUp()
    {
        $this->provider = new MemoryModelProvider();

        VirtualModelManager::getInstance()->setProvider(new TestSearchProvider());
        VirtualModelManager::getInstance()->setProvider(new TestCacheProvider());
        VirtualModelManager::getInstance()->setProvider(new TestTransactionProvider());

        $this->provider->memoryStorage = [
            ProductVm::class => [
                [
                    'id' => 1,
                    'name' => 'First',
                    'price' => 200,
                    'price2B' => 100,
                    'actions' => [],
                    'rests' => [
                        [
                            'productId' => 1,
                            'qty' => 10,
                            'userType' => 'b2c',
                        ]
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'Second',
                    'price' => 300,
                    'price2B' => 200,
                    'actions' => [],
                    'rests' => [
                        [
                            'productId' => 2,
                            'qty' => 10,
                            'userType' => 'b2c',
                        ]
                    ],
                ],
            ]
        ];

        $this->controller = new CrudController();
        VirtualModelManager::getInstance()->setProvider($this->provider);
    }

    public function tearDown()
    {
        unset($this->provider);
    }

    /**
     * @throws Exception
     */
    public function testList()
    {
        $pagination = new Pagination(1, 10);
        $items = $this->controller->actionList(
            ProductVm::class,
            $pagination
        );

        $this->assertEquals(2, count($items));
    }

    /**
     * @throws Exception
     */
    public function testView()
    {
        $item = $this->controller->actionView(ProductVm::class, 1);

        $this->assertEquals('First', $item->name);
    }

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $this->controller->actionEdit(ProductVm::class, [
            'id' => 3,
            'name' => 'Third',
            'price' => 200,
            'price2B' => 100,
            'actions' => [],
            'rests' => [],
        ]);

        $item = ProductVm::one([
            'where' => [
                ['=', 'id', 3]
            ]
        ]);

        $this->assertEquals('Third', $item->name);
    }

    /**
     * @throws Exception
     */
    public function testUpdate()
    {
        $this->controller->actionEdit(ProductVm::class, [
            'name' => 'Changed',
            'price' => 200,
            'price2B' => 100,
            'actions' => [],
            'rests' => [],
        ], 2);

        $item = ProductVm::one([
            'where' => [
                ['=', 'id', 2]
            ]
        ]);

        $this->assertEquals('Changed', $item->name);
    }
}