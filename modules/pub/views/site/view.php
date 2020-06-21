<?php

/** @var ProductVm $product */

use kosuha606\VirtualShop\Model\ProductVm;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $product->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= $product->name ?></h1>


<?php if ($product->sale_price && $product->hasDiscount) { ?>
    <span class="badge">Скидка</span>
    <p>
        <strike><?= $product->price ?> руб.</strike>
        <?= $product->sale_price ?> руб.
    </p>
<?php } else { ?>
    <p>
        Цена: <?= $product->price ?> руб.
    </p>
<?php } ?>
<?php $form = ActiveForm::begin(['action' => Url::toRoute('/cart/index'), 'method' => 'post']); ?>
<input type="hidden" name="product_id" value="<?= $product->id ?>">
<div class="row">
    <div class="col-sm-4 mb-3">
        <div class="row">
            <div class="col-sm-3">
                <button class="btn btn-default">В корзину</button>
            </div>
            <div class="col-sm-9">
                <input class="form-control" type="number" name="qty" value="1">
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
