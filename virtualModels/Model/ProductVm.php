<?php

namespace app\virtualModels\Model;



use app\models\Comment;
use app\virtualModels\Admin\Domains\Search\SearchableInterface;
use app\virtualModels\Admin\Domains\Search\SearchIndexDto;
use app\virtualModels\Admin\Domains\Search\SearchObserver;
use app\virtualModels\Admin\Domains\Seo\SeoModelInterface;
use app\virtualModels\Admin\Domains\Seo\SeoModelTrait;
use app\virtualModels\Admin\Domains\Seo\SeoUrlObserver;
use app\virtualModels\Domains\Cache\CacheAimInterface;
use app\virtualModels\Domains\Cache\CacheAimObserver;
use app\virtualModels\Domains\Cache\CacheEntityDto;
use app\virtualModels\Domains\Comment\Models\CommentVm;
use app\virtualModels\Domains\Multilang\MultilangTrait;
use kosuha606\VirtualModel\VirtualModel;
use app\virtualModels\ServiceManager;
use app\virtualModels\Services\ProductService;
use kosuha606\VirtualModelHelppack\Traits\ObserveVMTrait;
use yii\helpers\Url;

/**
 * Продукт
 * @property $rests
 *
 * @property $id
 * @property $name
 * @property $price
 * @property $slug
 * @property $price2B
 * @property $actions
 *
 */
class ProductVm extends VirtualModel
    implements
    CacheAimInterface,
    SearchableInterface,
    SeoModelInterface
{
    use ObserveVMTrait;

    use MultilangTrait;

    use SeoModelTrait;

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
            'slug',
            'price2B',
            'actions',
            'rests',
        ];
    }

    public function buildUrl()
    {
        return '/product/'.$this->id.'_'.$this->slug;
    }

    public function buildIndex(): SearchIndexDto
    {
        return new SearchIndexDto(1, [
            [
                'field' => 'title',
                'value' => $this->name,
                'type' => 'text',
            ],
            [
                'field' => 'url',
                'value' => Url::toRoute(['site/view', 'id' => $this->id]),
                'type' => 'keyword',
            ],
            [
                'field' => 'content',
                'value' => $this->price,
                'type' => 'text',
            ],
        ]);
    }

    public static function observers()
    {
        return [
            CacheAimObserver::class,
            SearchObserver::class,
            SeoUrlObserver::class,
        ];
    }

    public function cacheItems(): array
    {
        $rests = VirtualModel::allToArray(ProductRestsVm::many(['where' => [
            ['=', 'productId', $this->id]
        ]]));
        $cacheData = $this->toArray();
        $restsArr = array_column($rests, 'qty');
        $cacheData['rests'] = array_sum($restsArr);
        $comments = CommentVm::many(['where' => [
            ['=', 'model_id', $this->id],
            ['=', 'model_class', ProductVm::class]
        ]]);
        $cacheData['comments_qty'] = count($comments);

        return [
            new CacheEntityDto($this->id,  'id', 'product', $cacheData),
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