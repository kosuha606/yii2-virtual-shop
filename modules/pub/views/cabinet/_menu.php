<?php

use app\virtualModels\Model\FavoriteVm;
use app\virtualModels\Model\OrderVm;
use app\virtualModels\ServiceManager;
use yii\helpers\Html;

$user = ServiceManager::getInstance()->userService->current();

$ordersCount = OrderVm::count([
    'where' => [
        ['=', 'user_id', $user->id]
    ]
]);

$favoritesCount = FavoriteVm::count([
    'where' => [
        ['=', 'user_id', $user->id]
    ]
])

?>

<div class="list-group">
    <?= Html::a("Заказы 
    <span class='badge badge-primary badge-pill'>{$ordersCount}</span>", ['cabinet/orders'], ['class' => 'list-group-item  list-group-item-action']) ?>
    <?= Html::a("Избранное
    <span class='badge badge-primary badge-pill'>{$favoritesCount}</span>", ['cabinet/favorites'], ['class' => 'list-group-item  list-group-item-action']) ?>
    <?= Html::a('Профиль', ['cabinet/profile'], ['class' => 'list-group-item  list-group-item-action']) ?>
</div>
