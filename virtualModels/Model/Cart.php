<?php

namespace app\virtualModels\Model;

use app\virtualModels\ServiceManager;
use app\virtualModels\Services\CartService;

/**
 * Корзина
 * @NOTICE Корзина должна каждый раз быть построена при каждой загрузке приложения
 * @NOTICE Нужен враппер который будет заниматься построением корзины
 * @package kosuha606\Model\iteration2\model
 */
class Cart
{
    /**
     * @var CartItem[]
     */
    public $items = [];

    /**
     * @var PromocodeVm
     */
    public $promocode;

    /**
     * @var DeliveryVm
     */
    public $delivery;

    /**
     * @var PaymentVm
     */
    public $payment;

    /**
     * @var CartService
     */
    public $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @return float|int
     * @throws \Exception
     */
    public function complete()
    {
        return $this->cartService->calculateTotals($this);
    }

    public function applyPromocode(PromocodeVm $promocode)
    {
        $this->promocode = $promocode;
    }

    /**
     * @return float|int
     * @throws \Exception
     */
    public function getTotals()
    {
        return $this->cartService->calculateTotals($this);
    }

    /**
     * @param ProductVm $product
     * @param int $qty
     * @throws \Exception
     */
    public function addProduct(ProductVm $product, $qty = 1)
    {
        if ($product->hasFreeRests($qty)) {
            $this->items[] = new CartItem([
                'price' => $product->sale_price,
                'productId' => $product->id,
                'name' => $product->name,
                'qty' => $qty
            ]);
        } else {
            throw new \Exception('Нет доступных остатков по продукту');
        }
    }

    /**
     * @param DeliveryVm $delivery
     */
    public function setDelivery(DeliveryVm $delivery): void
    {
        $this->delivery = $delivery;
    }

    /**
     * @param PaymentVm $payment
     */
    public function setPayment(PaymentVm $payment): void
    {
        $this->payment = $payment;
    }
}