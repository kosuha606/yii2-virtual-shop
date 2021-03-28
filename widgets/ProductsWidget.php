<?php

namespace app\widgets;

use kosuha606\VirtualShop\Model\CategoryVm;
use kosuha606\VirtualShop\Model\FilterCategoryVm;
use kosuha606\VirtualShop\Model\FilterProductVm;
use kosuha606\VirtualShop\ServiceManager;
use kosuha606\VirtualShop\Services\ProductService;
use yii\base\Widget;
use Yii;
use yii\web\Request;

class ProductsWidget extends Widget
{
    public ?int $categoryId = null;
    private ProductService $productService;
    private Request $request;

    /**
     * @param ProductService $productService
     * @param Request $request
     * @param array $config
     */
    public function __construct(
        ProductService $productService,
        Request $request,
        $config = []
    ) {
        parent::__construct($config);
        $this->productService = $productService;
        $this->request = $request;
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $page = $this->request->get('page');
        $order = $this->request->get('order');

        $filtersData = [];
        /** @var FilterCategoryVm[] $filterCategories */
        $filterCategories = FilterCategoryVm::many(['where' => [['all']]]);

        foreach ($filterCategories as $filterCategory) {
            $filtersData[$filterCategory->name] = FilterProductVm::many([
                'select' => 'category_id, value',
                'where' => [['=', 'category_id', $filterCategory->id]],
                'groupBy' => 'value, category_id',
            ]);
        }

        $filters = $this->productService->processGetFilters(
            Yii::$app->request->get('filter')
        );

        if ($this->categoryId) {
            $filters['category_id'] = $this->categoryId;
        }

        $dto = ServiceManager::getInstance()->productService->loadProductsWithActions(
            $filters,
            $page,
            6,
            $order
        );

        $categories = CategoryVm::many(['where' => ['all']]);

        return $this->render('products', [
            'products' => $dto->products,
            'pagination' => $dto->pagination,
            'filtersData' => $filtersData,
            'categories' => $categories,
            'currentCategoryId' => $this->categoryId,
        ]);
    }
}
