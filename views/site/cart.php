<?php

/* @var $this yii\web\View */
/** @var Cart $cart */

use app\virtualModels\Model\Cart;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    Корзина
</h1>

<h3>Ваш заказ</h3>
<table class="table table-bordered">
    <?php foreach ($cart->items as $item) { ?>
    <tr>
        <td>
            <?= $item->name ?>
        </td>
        <td>
            <?= $item->qty ?> шт.
        </td>
        <td>
            <?= $item->price ?> руб.
        </td>
        <td>
            <a href="#">
                Удалить
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

<h2>Итог</h2>
<table class="table table-bordered">
    <tr>
        <th>
            Итого
        </th>
        <td>
            <?= $cart->getTotals() ?>
            руб.
        </td>
    </tr>
</table>

<a class="btn btn-primary" href="<?= Url::toRoute(['site/delivery']) ?>">Далее</a>