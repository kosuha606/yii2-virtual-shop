<?php

/* @var $this yii\web\View */

use app\virtualModels\Classes\Pagination;
use app\virtualModels\Domains\Multilang\TranslationService;
use app\virtualModels\Model\FilterProductVm;
use app\virtualModels\Model\ProductVm;
use app\widgets\ProductsWidget;use kosuha606\VirtualModel\Example\Shop\Model\Product;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/** @var ProductVm[] $products */
/** @var Pagination $pagination */
/** @var $filtersData */


$pagerPagination = new \yii\data\Pagination(
    [
        'totalCount' => $pagination->totals,
        'defaultPageSize' => $pagination->itemPerPage,
    ]
);

$order = Yii::$app->request->get('order');

$translationService = ServiceManager::getInstance()->get(TranslationService::class);

?>
<div class="site-index">
    <div class="body-content">
        <?= ProductsWidget::widget([]); ?>
    </div>
</div>
