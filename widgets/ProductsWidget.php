<?php

namespace app\widgets;

use app\virtualModels\Model\CategoryVm;
use yii\base\Widget;
use app\virtualModels\Model\FilterCategoryVm;
use app\virtualModels\Model\FilterProductVm;
use app\virtualModels\ServiceManager;
use Yii;

class ProductsWidget extends Widget
{
    public $categoryId;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function run()
    {
        $page = Yii::$app->request->get('page');
        $order = Yii::$app->request->get('order');

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

        $filters = ServiceManager::getInstance()->productService->processGetFilters(
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