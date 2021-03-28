<?php

/** @var Cart $cart */
/** @var array $cartData */

use kosuha606\VirtualShop\Model\Cart;
use yii\helpers\Html;

?>

<h1>
    Заказ завершен
</h1>

<?php if ($cart->hasItems()) { ?>
    <?php if (!Yii::$app->user->isGuest) { ?>
    <?= Html::a('Перейти в заказы', ['cabinet/orders']) ?>
    <?php } else { ?>
        Чтобы следить за своими заказами пройдите <?= Html::a('регистрацию', ['guest/register']) ?>.
    <?php } ?>
<?php } else { ?>
    Ваша корзина пуста
<?php } ?>
