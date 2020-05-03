<?php

use yii\helpers\Html;

?>

<div class="list-group">
    <?= Html::a('Заказы 
    <span class="badge badge-primary badge-pill">14</span>', ['cabinet/orders'], ['class' => 'list-group-item  list-group-item-action']) ?>
    <?= Html::a('Избранное
    <span class="badge badge-primary badge-pill">14</span>', ['cabinet/favorites'], ['class' => 'list-group-item  list-group-item-action']) ?>
    <?= Html::a('Профиль', ['cabinet/profile'], ['class' => 'list-group-item  list-group-item-action']) ?>
</div>
