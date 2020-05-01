<?php

/* @var $this yii\web\View */

use kosuha606\VirtualModel\Example\Shop\Model\Product;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var Product[] $products */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Пример интернет магазина</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <?php foreach ($products as $product) { ?>
                <div class="col-lg-4">
                    <?php $form = ActiveForm::begin(['action' => Url::toRoute('/site/cart'), 'method' => 'post']); ?>
                    <h2>
                        <a href="<?= Url::toRoute(['site/view', 'id' => $product->id]) ?>">
                            <?= $product->name ?>
                        </a>
                    </h2>
                    <p>
                        <?= $product->sale_price ?> руб.
                    </p>
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <div class="row">
                        <div class="form-group mb-3">
                            <div class="col-sm-3">
                                <button class="btn btn-default">В корзину</button>
                            </div>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" name="qty" value="1">
                            </div>
                        </div>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
