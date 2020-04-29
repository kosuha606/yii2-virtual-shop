<?php

namespace app\virtualModels;

use app\virtualModels\Cart\CartBuilder;
use app\virtualModels\Services\CartService;
use app\virtualModels\Services\DeliveryService;
use app\virtualModels\Services\OrderService;
use app\virtualModels\Services\PaymentService;
use app\virtualModels\Services\ProductService;
use app\virtualModels\Services\PromocodeService;
use app\virtualModels\Services\UserService;

/**
 * @property UserService $userService
 * @property ProductService $productService
 * @property CartService $cartService
 * @property PaymentService $paymentService
 * @property DeliveryService $deliveryService
 * @property PromocodeService $promocodeService
 * @property CartBuilder $cartBuilder
 */
class ServiceManager
{
    private static $instance;

    private $services = [];

    private $type;

    public function __construct($type)
    {
        $this->services = [
            'userService' => new UserService(),
        ];

        $this->services['paymentService'] = new PaymentService();
        $this->services['deliveryService'] = new DeliveryService();
        $this->services['promocodeService'] = new PromocodeService();
        $this->services['orderService'] = new OrderService($this->services['userService']);
        $this->services['productService'] = new ProductService($this->services['orderService']);
        $this->services['cartService'] = new CartService(
            $this->services['orderService'],
            $this->services['paymentService'],
            $this->services['deliveryService'],
            $this->services['promocodeService']
        );
        $this->services['cartBuilder'] = new CartBuilder(
            $this->services['cartService'],
            $this->services['productService']
        );

        $this->type = $type;
    }

    public function __get($name)
    {
        return $this->services[$name];
    }

    public static function getInstance($type = 'bad')
    {
        if (!self::$instance) {
            self::$instance = new self($type);
        }
        self::$instance->type = $type;

        return self::$instance;
    }
}