<?php

use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Test\TestRequestProvider;
use app\virtualModels\Admin\Test\TestSessionProvider;
use app\virtualModels\Model\ProductRestsVm;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModel\VirtualModelManager;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualModelHelppack\Test\VirtualTestCase;
use PHPUnit\Framework\TestCase;

class SecondaryFormTest extends VirtualTestCase
{
    public $sessionProvider;

    public $requestProvider;

    public function setUp()
    {
        parent::setUp();
        $this->provider->memoryStorage = [
            ProductRestsVm::class => [
                [
                    'productId' => 1,
                    'qty' => 10,
                    'userType' => 'b2c',
                ],
                [
                    'productId' => 1,
                    'qty' => 15,
                    'userType' => 'b2b',
                ],
            ],
            ProductVm::class => [
                [
                    'id' => 1,
                    'name' => 'Первый',
                    'price' => 100,
                    'price2B' => 200,
                ]
            ]
        ];

        $this->sessionProvider = new TestSessionProvider();
        $this->requestProvider = new TestRequestProvider();

        VirtualModelManager::getInstance()->setProvider($this->sessionProvider);
        VirtualModelManager::getInstance()->setProvider($this->requestProvider);
    }

    /**
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws Exception
     */
    public function testForm()
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $product = ProductVm::one(['where' => [['=', 'id', 1]]]);

        $config = $secondaryService->buildForm()
            ->setMasterModel($product)
            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
            ->setRelationClass(ProductRestsVm::class)
            ->setTabName('Остатки')
            ->setRelationEntities(ProductRestsVm::many(['where' => [['=', 'productId', $product->id]]]))
            ->setConfig(function ($model) {
                return [
                    [
                        'field' => 'productId',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $model->productId,
                    ],
                    [
                        'field' => 'qty',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $model->qty,
                    ],
                    [
                        'field' => 'userType',
                        'component' => DetailComponents::INPUT_FIELD,
                        'value' => $model->userType,
                    ],
                ];
            })
            ->getConfig()
        ;

        // В сессию записывается одна запись
        $this->assertEquals(1, count($this->sessionProvider->memoryStorage));
        $configString = json_encode($config, JSON_UNESCAPED_UNICODE);
        $this->assertEquals($configString, '{"tab":"Остатки","initialConfig":[{"field":"productId","component":"InputField","value":null},{"field":"qty","component":"InputField","value":null},{"field":"userType","component":"InputField","value":null}],"dataConfig":[[{"field":"productId","component":"InputField","value":1},{"field":"qty","component":"InputField","value":10},{"field":"userType","component":"InputField","value":"b2c"}],[{"field":"productId","component":"InputField","value":1},{"field":"qty","component":"InputField","value":15},{"field":"userType","component":"InputField","value":"b2b"}]]}');
    }
}