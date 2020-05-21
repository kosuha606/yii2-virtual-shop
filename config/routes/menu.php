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