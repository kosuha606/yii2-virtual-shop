<?php

use kosuha606\VirtualShop\Model\Cart;
use kosuha606\VirtualShop\ServiceManager;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var Cart $cart */

$this->params['breadcrumbs'][] = [
    'label' => 'Корзина',
    'url' => Url::toRoute('/cart/index'),
];
$this->params['breadcrumbs'][] = 'Завершение заказа';
?>
    <h1>Завершение заказа</h1>


<?php $form = ActiveForm::begin(['action' => Url::toRoute('/cart/complete'), 'method' => 'post']); ?>

    <input type="hidden" name="cart_data" value="<?= Html::encode(Json::encode(ServiceManager::getInstance()->cartBuilder->serialize())) ?>">

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
            </tr>
        <?php } ?>
        <tr>
            <td>
                Итого цена продуктов
            </td>
            <td colspan="2">
                <?= $cart->getProductsTotal() ?> руб.
            </td>
        </tr>
    </table>

    <h3>Доставка</h3>
    <table class="table table-bordered">
        <tr>
            <td>
                <?= $cart->delivery->description ?>
            </td>
            <td>
                <?= $cart->delivery->price ?> руб.
            </td>
        </tr>
    </table>

    <h3>Оплата</h3>
    <table class="table table-bordered">
        <tr>
            <td>
                <?= $cart->payment->description ?>
            </td>
            <td>
                <?= $cart->payment->comission ?> руб.
            </td>
        </tr>
    </table>

    <?php if ($cart->promocode) { ?>
        <h3>Промокод</h3>
        <p>
            <?= $cart->promocode->code ?> на <?= $cart->promocode->amount ?> руб.
        </p>
    <?php } ?>

    <h3>Итог</h3>
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

    <button class="btn btn-primary">Завершить заказ</button>

<?php ActiveForm::end(); ?>