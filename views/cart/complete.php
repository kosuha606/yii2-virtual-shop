<?php

/** @var Cart $cart */
/** @var array $cartData */

use app\virtualModels\Model\Cart;
use yii\helpers\Html;

?>

<h1>
    Заказ завершен
</h1>

<?php if ($cart->hasItems()) { ?>
<!--    <pre>-->
<!--        --><?php //var_dump($cartData) ?>
<!--    </pre>-->
    <?php if (!Yii::$app->user->isGuest) { ?>
    <?= Html::a('Перейти в заказы', ['cabinet/orders']) ?>
    <?php } else { ?>
        Чтобы следить за своими заказами пройдите <?= Html::a('регистрацию', ['guest/register']) ?>.
    <?php } ?>
<?php } else { ?>
    Ваша корзина пуста
<?php } ?>
