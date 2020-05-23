<?php

use app\virtualModels\Domains\Menu\Models\MenuVm;
use yii\helpers\Inflector;

$baseEntity = 'menu';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = MenuVm::class;
$listTitle = 'Меню';
$detailTitle = 'Меню';

return [
    'menu' => [
        'content' => [
            'name' => 'content',
            'label' => 'Контент',
        ],
        'users' => [
            'name' => 'users',
            'label' => 'Пользователи',
        ],
        'store' => [
            'name' => 'store',
            'label' => 'Магазин',
        ],
        'system' => [
            'name' => 'system',
            'label' => 'Система',
        ],
    ]
];