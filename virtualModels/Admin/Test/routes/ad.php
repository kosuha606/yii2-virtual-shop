<?php

use app\virtualModels\Model\AdVm;
use app\virtualModels\Structures\DetailComponents;
use app\virtualModels\Structures\ListComponents;

return [
    'routes' => [
        'ad' => [
            'detail' => [
                'menu' => [
                    'name' => 'ad_detail',
                    'label' => 'Объявление',
                    'url' => '/admin/ad/detail',
                    'visible' => false,
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => 'Объявление',
                    'component' => 'detail',
                    'crud' => [
                        'model' => AdVm::class,
                        'action' => 'actionView'
                    ],
                    'config' => [
                        [
                            'field' => 'name',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'Имя'
                        ],
                        [
                            'field' => 'phone',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'Телефон'
                        ],
                        [
                            'field' => 'email',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'Email'
                        ],

                    ]
                ]
            ],
            'list' => [
                'menu' => [
                    'name' => 'ad_list',
                    'label' => 'Список объявлений',
                    'url' => '/admin/ad/list',
                    'parent' => 'ad',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => 'Объявления',
                    'component' => 'list',
                    'crud' => [
                        'model' => AdVm::class,
                        'action' => 'actionList'
                    ],
                    'config' => [
                        [
                            'field' => 'id',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'ID'
                        ],
                        [
                            'field' => 'name',
                            'component' => ListComponents::STRING_CELL,
                            'props' => [
                                'link' => 1
                            ],
                            'label' => 'Имя'
                        ],
                        [
                            'field' => 'phone',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Телефон'
                        ],
                    ]
                ]
            ]
        ]
    ]
];