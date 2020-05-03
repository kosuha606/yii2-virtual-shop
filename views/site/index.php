<?php

/* @var $this yii\web\View */

use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModel\Example\Shop\Model\Product;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var ProductVm[] $products */

$this->title = 'My Yii Application';
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
                    <?php foreach ($products as $product) { ?>
                        <div class="col-lg-4">
                            <?php $form = ActiveForm::begin(['action' => Url::toRoute('/cart/index'), 'method' => 'post']); ?>
                            <h2>
                                <a href="<?= Url::toRoute(['site/view', 'id' => $product->id]) ?>">
                                    <?= $product->name ?>
                                </a>
                            </h2>
                            <p>
                                <?= $product->sale_price ?> руб.
                            </p>
                            <?php if ($product->hasFreeRests(1)) { ?>
                                <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <div class="col-sm-4">
                                            <button class="btn btn-default">В корзину</button>
                                        </div>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number" max="<?= $product->maxRestAmount() ?>" name="qty" value="1">
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
            </div>
        </div>



    </div>
</div>
