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
        'store' => [
            'name' => 'store',
            'label' => 'Магазин',
        ],
        'seo' => [
            'name' => 'seo',
            'label' => 'SEO',
        ],
        'inter' => [
            'name' => 'inter',
            'label' => 'Интернационализация',
        ],
        'system' => [
            'name' => 'system',
            'label' => 'Система',
        ],
        'users' => [
            'name' => 'users',
            'label' => 'Пользователи',
        ],
    ]
];