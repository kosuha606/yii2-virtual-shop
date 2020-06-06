<?php

/* @var $this yii\web\View */

use app\virtualModels\Classes\Pagination;
use app\virtualModels\Model\FilterProductVm;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModel\Example\Shop\Model\Product;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/** @var ProductVm[] $products */
/** @var Pagination $pagination */
/** @var $filtersData */

$this->title = 'My Yii Application';

$pagerPagination = new \yii\data\Pagination(
    [
        'totalCount' => $pagination->totals,
        'defaultPageSize' => $pagination->itemPerPage,
    ]
);

$order = Yii::$app->request->get('order');

?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-3">
                <h2>Фильтры</h2>
                <form method="get">
                    <?php foreach ($filtersData as $categoryName => $filterProducts) { ?>
                        <h3><?= $categoryName ?></h3>
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
                                    <?= $filterProduct->value ?>
                                </label>
                            </div>
                        <?php } ?>
                    <?php } ?>
                    <hr>
                    <button class="btn btn-default">
                        Применить
                    </button>
                    <div>
                        <?= Html::a('Сбросить', ['site/index']) ?>
                    </div>
                </form>
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
                                        <option <?= $order == 'id' ? 'selected' : '' ?> value="id">По умолчанию</option>
                                        <option <?= $order == 'name' ? 'selected' : '' ?> value="name">По имени &uarr;
                                        </option>
                                        <option <?= $order == 'name_reverse' ? 'selected' : '' ?> value="name_reverse">
                                            По имени &darr;
                                        </option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-default">Применить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>

                <div class="products">
                    <?php foreach ($products as $product) { ?>
                        <div class="product-item">
                            <h2>
                                <a href="<?= $product->getUrl() ?>">
                                    <?= $product->langAttribute('name') ?>
                                </a>
                            </h2>
                            <?php if ($product->hasDiscount) { ?>
                                <span class="badge">Скидка</span>
                                <p>
                                    <strike><?= $product->price ?> руб.</strike>
                                    <?= $product->sale_price ?> руб.
                                </p>
                            <?php } else { ?>
                                <p>
                                    <?= $product->price ?> руб.
                                </p>
                            <?php } ?>
                            <?= $this->render('_tofavorite', ['product' => $product]) ?>
                            <hr>
                            <?php $form = ActiveForm::begin(
                                ['action' => Url::toRoute('/cart/index'), 'method' => 'post']
                            ); ?>

                            <?php if ($product->hasFreeRests(1)) { ?>
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <div class="col-sm-4">
                                            <button class="btn btn-default">В корзину</button>
                                        </div>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number" min="0"
                                                   max="<?= $product->maxAvailableRestAmount() ?>" name="qty" value="1">
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <b>Нет в наличии</b>
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


    </div>
</div>
