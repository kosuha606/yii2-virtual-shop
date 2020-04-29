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
                    <h2><?= $product->name ?></h2>
                    <p>
                        <?= $product->sale_price ?> руб.
                    </p>
                    <div>
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">
                        <button class="btn btn-default">В корзину</button>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            <?php } ?>
        </div>

    </div>
</div>
