<?php

use app\virtualModels\Model\DeliveryVm;
use app\virtualModels\Model\FavoriteVm;
use app\virtualModels\Model\PaymentVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\PromocodeVm;
use app\virtualModels\Model\UserVm;
use app\virtualModels\ServiceManager;
use kosuha606\VirtualModel\Example\MemoryModelProvider;
use kosuha606\VirtualModel\VirtualModelManager;
use PHPUnit\Framework\TestCase;

class FavoriteTest extends TestCase
{
    /** @var MemoryModelProvider  */
    private $provider;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->provider = new MemoryModelProvider();

        $this->provider->memoryStorage = [
            ProductVm::class => [
                [
                    'id' => 1,
                    'name' => 'First',
                    'price' => 100,
                    'price2B' => 200,
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
                    'price' => 200,
                    'price2B' => 400,
                    'actions' => [],
                    'rests' => [
                        [
                            'productId' => 2,
                            'qty' => 10,
                            'userType' => 'b2c',
                        ]
                    ],
                ],
            ],
        ];

        $user = UserVm::create(
            [
                'id' => 1,
                'personalDiscount' => 0,
            ]
        );
        ServiceManager::getInstance()->userService->setUser($user);

        VirtualModelManager::getInstance()->setProvider($this->provider);
    }

    public function tearDown(): void
    {
        unset($this->provider);
    }

    /**
     * @throws Exception
     */
    public function testAdd()
    {
        $product = ProductVm::one([
            'where' => [
                ['=', 'id', 1]
            ]
        ]);
        $user = ServiceManager::getInstance()->userService->current();
        ServiceManager::getInstance()->favoriteService->addUserProduct($user, $product);

        $userFavorites = FavoriteVm::many([
            'where' => [
                ['=', 'user_id', $user->id]
            ]
        ]);

        $this->assertEquals(1, count($userFavorites));
    }
}