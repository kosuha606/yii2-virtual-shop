<?php

use yii\helpers\Html; ?>

<div class="list-group">
    <?= Html::a('Заказы', ['cabinet/orders'], ['class' => 'list-group-item  list-group-item-action']) ?>
    <?= Html::a('Избранное', ['cabinet/favorites'], ['class' => 'list-group-item  list-group-item-action']) ?>
    <?= Html::a('Профиль', ['cabinet/profile'], ['class' => 'list-group-item  list-group-item-action']) ?>
</div>
