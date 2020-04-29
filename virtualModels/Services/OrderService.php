<?php

namespace app\virtualModels\Services;


use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\OrderReserve;
use app\virtualModels\Model\Product;

class OrderService
{
    /** @var UserService */
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param Product $product
     * @return int
     * @throws \Exception
     */
    public function findOrderReserveQtyByProduct(Product $product)
    {
        $reservedQty = 0;

        foreach ($this->getOrderReserve() as $item) {
            if ($item->productId === $product->id) {
                $reservedQty += $item->qty;
            }
        }

        return $reservedQty;
    }

    public function currentUser()
    {
        return $this->userService->current();
    }

    /**
     * @return OrderReserve[]
     * @throws \Exception
     */
    public function getOrderReserve()
    {
        $items = VirtualModelManager::getInstance()->getProvider()->many(OrderReserve::class, [
            'where' => [
                ['all']
            ]
        ]);

        return $items;
    }
}