<?php

/* @var $this yii\web\View */

/** @var Cart $cart */
/** @var DeliveryVm[] $deliveries */
/** @var PaymentVm[] $payments */

use app\virtualModels\Model\Cart;
use app\virtualModels\Model\DeliveryVm;
use app\virtualModels\Model\PaymentVm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Корзина';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>
    Корзина

    <?php if ($cart->hasItems()) { ?>
    <small>
        <small>
            <a href="<?= Url::toRoute(['cart/clearall']) ?>">
                удалить все товары
            </a>
        </small>
    </small>
    <?php } ?>
</h1>

<?php if ($cart->hasItems()) { ?>
    <?php $form = ActiveForm::begin(['action' => Url::toRoute('/cart/checkout'), 'method' => 'post']); ?>

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
                    <a href="<?= Url::toRoute(['/cart/delete', 'id' => $item->productId]) ?>">
                        Удалить
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <h3>Способ доставки</h3>
    <?php foreach ($deliveries as $delivery) { ?>
        <div>
            <label>
                <input type="radio" name="delivery_id" value="<?= $delivery->id ?>">
                <?= $delivery->description ?>
                (<?= $delivery->price ?> руб.)
            </label>
        </div>
    <?php } ?>


    <h3>Способ оплаты</h3>
    <?php foreach ($payments as $payment) { ?>
        <div>
            <label>
                <input type="radio" name="payment_id" value="<?= $payment->id ?>">
                <?= $payment->description ?>
                (Комиссия <?= $payment->comission ?> руб.)
            </label>
        </div>
    <?php } ?>

    <h3>Промокод</h3>
    <input placeholder="Введите ваш код" class="form-control" type="text" name="promocode" />

    <h3>Итог</h3>
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

    <button class="btn btn-primary">Продолжить</button>

    <?php ActiveForm::end(); ?>
<?php } else { ?>
    <p>Нет товаров в корзине</p>
<?php } ?>
