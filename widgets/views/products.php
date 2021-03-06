<?php


use kosuha606\VirtualAdmin\Classes\Pagination;
use kosuha606\VirtualAdmin\Domains\Multilang\TranslationService;
use kosuha606\VirtualAdmin\Domains\Seo\SeoFilterService;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualShop\Model\CategoryVm;
use kosuha606\VirtualShop\Model\FilterProductVm;
use kosuha606\VirtualShop\Model\ProductVm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;



/** @var ProductVm[] $products */
/** @var Pagination $pagination */
/** @var $filtersData */
/** @var CategoryVm[] $categories */
/** @var $currentCategoryId */


$pagerPagination = new \yii\data\Pagination(
    [
        'totalCount' => $pagination->totals,
        'defaultPageSize' => $pagination->itemPerPage,
    ]
);

$order = Yii::$app->request->get('order');

$translationService = ServiceManager::getInstance()->get(TranslationService::class);

?>

<div class="row">
    <div class="col-md-3">
        <h2><?= $translationService->translate('Категории') ?></h2>
        <div class="list-group">
            <?php foreach ($categories as $category) { ?>
            <a href="<?= $category->getUrl() ?>" class="list-group-item <?= $currentCategoryId == $category->id ? 'active' : '' ?>">
                <span class="badge"><?= $category->getProductsCount() ?></span>
                <?= $category->langAttribute('name') ?>
            </a>
            <?php } ?>
        </div>


        <h2><?= $translationService->translate('Фильтры') ?></h2>
        <?php $form = ActiveForm::begin(['method' => 'post', 'action' => ['/pub/category/filter']]) ?>
            <?php foreach ($filtersData as $categoryName => $filterProducts) { ?>
                <?php
                if ($currentCategoryId && $categoryName === 'Тип') {
                    continue;
                }
                ?>
                <h3><?= $translationService->translate($categoryName) ?></h3>
                <?php
                /** @var FilterProductVm $filterProduct */
                foreach ($filterProducts as $filterProduct) { ?>
                    <div>
                        <label for="<?= $filterProduct->value ?>">
                            <input id="<?= $filterProduct->value ?>"
                                   type="checkbox"
                                <?= $filterProduct->isActive() ? 'checked' : '' ?>
                                   name="filter[]"
                                   value="<?= $filterProduct->getKey() ?>">
                            <?= $translationService->translate($filterProduct->value) ?>
                        </label>
                    </div>
                <?php } ?>
            <?php } ?>
            <hr>
            <button class="btn btn-default">
                <?= $translationService->translate('Применить') ?>
            </button>
            <div>
                <?php
                    $seoFilterService = ServiceManager::getInstance()->get(SeoFilterService::class);
                ?>
                <?= Html::a($translationService->translate('Сбросить'), $seoFilterService->urlWithoutFilter(Yii::$app->request->pathInfo)) ?>
            </div>
        <?php ActiveForm::end() ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
                <?= LinkPager::widget(
                    [
                        'pagination' => $pagerPagination,
                    ]
                ) ?>
            </div>
            <div class="col-md-4">
                <form method="get">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <select name="order" class="form-control">
                                <option <?= $order == 'id' ? 'selected' : '' ?> value="id">
                                    <?= $translationService->translate('По умолчанию') ?>
                                </option>
                                <option <?= $order == 'name' ? 'selected' : '' ?> value="name">
                                    <?= $translationService->translate('По имени') ?>
                                    &uarr;
                                </option>
                                <option <?= $order == 'name_reverse' ? 'selected' : '' ?> value="name_reverse">
                                    <?= $translationService->translate('По имени') ?>
                                    &darr;
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-default">
                                <?= $translationService->translate('Применить') ?>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <hr>

        <div class="products">
            <?php foreach ($products as $product) { ?>
                <div class="product-item">

                    <a href="<?= $product->getUrl() ?>">
                        <div class="product-image">
                            <?= Html::img($product->getPhotoSafe(), []) ?>
                        </div>
                        <h2>
                            <?= $product->langAttribute('name') ?>
                        </h2>
                    </a>
                    <?php if ($product->hasDiscount) { ?>
                        <span class="badge">
                                    <?= $translationService->translate('Скидка') ?>
                                </span>
                        <p>
                            <strike><?= $product->price ?>
                                <?= $translationService->translate('руб') ?>
                            </strike>
                            <?= $product->sale_price ?>
                            <?= $translationService->translate('руб') ?>
                        </p>
                    <?php } else { ?>
                        <p>
                            <?= $product->price ?> <?= $translationService->translate('руб') ?>
                        </p>
                    <?php } ?>
                    <?= $this->render('/site/_tofavorite', ['product' => $product]) ?>
                    <hr>
                    <?php $form = ActiveForm::begin(
                        ['action' => Url::toRoute('/cart/index'), 'method' => 'post']
                    ); ?>

                    <?php if ($product->hasFreeRests(1)) { ?>
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <div class="row">
                            <div class="form-group mb-3">
                                <div class="col-sm-4">
                                    <button class="btn btn-default">
                                        <?= $translationService->translate('В корзину') ?>
                                    </button>
                                </div>
                                <div class="col-sm-8">
                                    <input class="form-control" type="number" min="0"
                                           max="<?= $product->maxAvailableRestAmount() ?>" name="qty" value="1">
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <b>
                            <?= $translationService->translate('Нет в наличии') ?>
                        </b>
                    <?php } ?>
                    <?php ActiveForm::end(); ?>
                </div>
            <?php } ?>
        </div>

        <hr>

        <?= LinkPager::widget(
            [
                'pagination' => $pagerPagination,
            ]
        ) ?>
    </div>
</div>
