<?php

namespace app\virtualModels\Services;


use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\OrderReserveVm;
use app\virtualModels\Model\ProductVm;

class OrderService
{
    /** @var UserService */
    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param ProductVm $product
     * @return int
     * @throws \Exception
     */
    public function findOrderReserveQtyByProduct(ProductVm $product)
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
     * @return OrderReserveVm[]
     * @throws \Exception
     */
    public function getOrderReserve()
    {
        $items = VirtualModelManager::getInstance()->getProvider()->many(OrderReserveVm::class, [
            'where' => [
                ['all']
            ]
        ]);

        return $items;
    }
}