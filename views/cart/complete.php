<?php

/** @var Cart $cart */
/** @var array $cartData */

use app\virtualModels\Model\Cart;

?>

<h1>
    Заказ завершен
</h1>

<?php if ($cart->hasItems()) { ?>
    <pre>
        <?php var_dump($cartData) ?>
    </pre>
<?php } else { ?>
    Ваша корзина пуста
<?php } ?>
