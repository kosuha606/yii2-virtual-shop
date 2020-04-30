<?php

/* @var $this yii\web\View */
/** @var Cart $cart */

use app\virtualModels\Model\Cart;
use yii\helpers\Html;

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
    </tr>
    <?php } ?>
</table>

<h2>Итог</h2>
<table class="table table-bordered">
    <tr>
        <th>
            Итого к оплате
        </th>
        <td>
            <?= $cart->getTotals() ?>
            руб.
        </td>
    </tr>
</table>