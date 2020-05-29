<?php

namespace app\virtualModels\Model;



use app\virtualModels\Domains\Cache\CacheAimInterface;
use app\virtualModels\Domains\Cache\CacheAimObserver;
use app\virtualModels\Domains\Cache\CacheEntityDto;
use kosuha606\VirtualModel\VirtualModel;
use app\virtualModels\ServiceManager;
use app\virtualModels\Services\ProductService;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;

/**
 * Продукт
 * @property $rests
 */
class ProductVm extends VirtualModel implements CacheAimInterface
{
    use ObserveVMTrait;

    /** @var ProductService */
    private $productService;

    public $hasDiscount = false;

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

    public static function observers()
    {
        return [
            CacheAimObserver::class
        ];
    }

    public function cacheItems(): array
    {
        return [
            new CacheEntityDto($this->id, static::class, $this->toArray()),
        ];
    }

    public function __construct($environment = 'db')
    {
        $this->productService = ServiceManager::getInstance()->productService;
        parent::__construct($environment);
    }

    public function setAttribute($name, $value)
    {
        $result = parent::setAttribute($name, $value);

        if ($name === 'actions') {
            if ($this->price != $this->getSalePrice()) {
                $this->hasDiscount = true;
            }
        }

        return $result;
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
                    ['=', 'productId', $this->id],
                ],
            ]);
            $this->setAttribute('rests', $rests);
        } elseif (isset($this->attributes['rests'][0])
            && is_array($this->attributes['rests'][0])
        ) {
            $rests = ProductRestsVm::createMany($this->attributes['rests']);
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
     * @return int
     */
    public function maxAvailableRestAmount()
    {
        return $this->productService->maxAvailableRestAmount($this);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function isInFavorite()
    {
        return $this->productService->isInFavorite($this);
    }

    /**
     *
     */
    public function maxRestAmount()
    {
        $rests = $this->rests;
        $amount = 0;
        /** @var ProductRestsVm $rest */
        foreach ($rests as $rest) {
            $amount += $rest->qty;
        }

        return $amount;
    }

    /**
     * Получить цену за которую нужно продать товар
     * @return float|int
     * @throws \Exception
     */
    public function getSalePrice()
    {
        if (!$this->actions) {
            $this->actions = ActionVm::many(['where' => [['all']]]);
        }

        return $this->productService->calculateProductSalePrice($this);
    }
}