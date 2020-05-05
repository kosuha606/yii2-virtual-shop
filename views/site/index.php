<?php

/* @var $this yii\web\View */

use app\virtualModels\Classes\Pagination;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModel\Example\Shop\Model\Product;
use yii\helpers\Url;
use yii\widgets\ActiveForm;use yii\widgets\LinkPager;

/** @var ProductVm[] $products */
/** @var Pagination $pagination */

$this->title = 'My Yii Application';

$pagerPagination = new \yii\data\Pagination([
    'totalCount' => $pagination->totals,
    'defaultPageSize' => $pagination->itemPerPage,
]);

$order = Yii::$app->request->get('order');

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Пример интернет магазина</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-3">
                <h2>Фильтры</h2>
                // TODO реализовать
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <form method="get">
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <select name="order" class="form-control">
                                        <option <?= $order == 'id' ? 'selected' : '' ?> value="id">По умолчанию</option>
                                        <option <?= $order == 'name' ? 'selected' : '' ?> value="name">По имени &uarr;</option>
                                        <option <?= $order == 'name_reverse' ? 'selected' : '' ?> value="name_reverse">По имени &darr;</option>
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <button class="btn btn-default">Применить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="products">
                    <?php foreach ($products as $product) { ?>
                        <div class="product-item">
                            <h2>
                                <a href="<?= Url::toRoute(['site/view', 'id' => $product->id]) ?>">
                                    <?= $product->name ?>
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
                            <?php $form = ActiveForm::begin(['action' => Url::toRoute('/cart/index'), 'method' => 'post']); ?>

                            <?php if ($product->hasFreeRests(1)) { ?>
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <div class="col-sm-4">
                                            <button class="btn btn-default">В корзину</button>
                                        </div>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number" min="0" max="<?= $product->maxAvailableRestAmount() ?>" name="qty" value="1">
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

                <?= LinkPager::widget([
                        'pagination' => $pagerPagination,
                    ])  ?>
            </div>
        </div>



    </div>
</div>
