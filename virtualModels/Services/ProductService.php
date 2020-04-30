<?php

namespace app\virtualModels\Services;


use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\ActionVm;
use app\virtualModels\Model\ProductVm;

class ProductService
{
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return ActionVm[]
     * @throws \Exception
     */
    public function findAllActions()
    {
        $actions = VirtualModelManager::getInstance()->getProvider()->many(ActionVm::class, [
            'where' => [
                ['all']
            ]
        ]);

        return $actions;
    }

    /**
     * @return ProductVm
     * @throws \Exception
     */
    public function findProductById($productId)
    {
        /** @var ProductVm $product */
        $product = ProductVm::one([
            'where' => [
                ['=', 'id', $productId]
            ]
        ]);

        return $product;
    }

    /**
     * @param ProductVm $product
     * @param $qty
     * @return bool
     * @throws \Exception
     */
    public function hasFreeRests($product, $qty)
    {
        $totalFreeQty = 0;

        if ($product->rests) {
            foreach ($product->rests as $productRest) {
                $totalFreeQty += $productRest->qty;
            }
        }

        $reservedInOrdersQty = $this->orderService->findOrderReserveQtyByProduct($product);
        $totalFreeQty -= $reservedInOrdersQty;

        return $totalFreeQty >= $qty;
    }

    public function calculateProductSalePrice($product)
    {
        $price = $product->price;

        if ($product->actions) {
            foreach ($product->actions as $action) {
                if (in_array($product->id, $action->productIds)) {
                    $price -= $price * ($action->percent/100);
                }
            }
        }

        return $price;
    }
}