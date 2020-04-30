<?php

namespace app\virtualModels\Model;



use kosuha606\VirtualModel\VirtualModel;
use app\virtualModels\ServiceManager;
use app\virtualModels\Services\ProductService;

/**
 * Продукт
 */
class ProductVm extends VirtualModel
{
    /** @var ProductService */
    private $productService;

    /**
     * Виртуальный атритут за который действительно продается товар
     * @var int
     */
    private $sale_price;

    public function attributes(): array
    {
        return [
            'id',
            'name',
            'price',
            'price2B',
            'actions',
            'rests',
        ];
    }

    public function __construct($environment = 'db')
    {
        $this->productService = ServiceManager::getInstance()->productService;
        parent::__construct($environment);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getRests()
    {
        if (!$this->attributes['rests']) {
            $rests = ProductRestsVm::many([
                'where' => [
                    ['=', 'id', $this->id]
                ]
            ]);
            $this->setAttribute('rests', $rests);
        }

        return $this->attributes['rests'];
    }

    /**
     * Проверяет имеются ли свободные остатки по
     * продукту
     * @param $qty
     * @return bool
     * @NOTICE Переделал, теперь происходит делегирование логики к дружественному классу-сервису
     * @throws \Exception
     */
    public function hasFreeRests($qty)
    {
        return $this->productService->hasFreeRests($this, $qty);
    }

    /**
     * Получить цену за которую нужно продать товар
     * @return float|int
     */
    public function getSalePrice()
    {
        return $this->productService->calculateProductSalePrice($this);
    }
}