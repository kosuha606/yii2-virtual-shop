<?php

namespace app\virtualModels\Services;


use app\virtualModels\ServiceManager;
use kosuha606\VirtualModel\VirtualModelManager;
use app\virtualModels\Model\ActionVm;
use app\virtualModels\Model\ProductVm;

class ProductService
{
    /**
     * @var OrderService
     */
    private $orderService;
    /**
     * @var FavoriteService
     */
    private $favoriteService;

    public function __construct(OrderService $orderService, FavoriteService $favoriteService)
    {
        $this->orderService = $orderService;
        $this->favoriteService = $favoriteService;
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

    /**
     * @param ProductVm $product
     * @return bool
     * @throws \Exception
     */
    public function isInFavorite(ProductVm $product)
    {
        $user = ServiceManager::getInstance()->userService->current();
        if (!$user) {
            return false;
        }

        return $this->favoriteService->hasFavorite($user, $product);
    }

    public function maxAvailableRestAmount(ProductVm $productVm)
    {
        $reservedInOrdersQty = $this->orderService->findOrderReserveQtyByProduct($productVm);
        $maxRestAmount = $productVm->maxRestAmount();

        $amount = $maxRestAmount - $reservedInOrdersQty;

        if ($amount <= 0) {
            $amount = 0;
        }

        return $amount;
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