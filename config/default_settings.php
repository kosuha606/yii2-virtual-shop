<?php


use kosuha606\VirtualAdmin\Structures\DetailComponents;

return [
    'Основные' => [
        [
            'field' => 'site_name',
            'component' => DetailComponents::INPUT_FIELD,
            'label' => 'Название сайта',
            'value' => "VirtualShop",
        ],
        [
            'field' => 'site_logo',
            'component' => DetailComponents::IMAGE_FIELD,
            'label' => 'Логотип',
            'value' => "",
        ],
    ],
    'Админка' => [
        [
            'field' => 'admin_color',
            'component' => DetailComponents::INPUT_FIELD,
            'label' => 'Цвет админки',
            'value' => "#f00",
        ],
    ]
];