<?php

use app\virtualModels\Model\OrderVm;
use app\virtualModels\Model\UserVm;
use app\virtualModels\Services\StringService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Structures\ListComponents;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'order';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = OrderVm::class;
$listTitle = 'Заказы';
$detailTitle = 'Заказ';

return [
    'routes' => [
        $baseEntity => [
            'list' => [
                'menu' => [
                    'name' => $baseEntity.'_list',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/list',
                    'parent' => 'store',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $listTitle,
                    'entity' => $baseEntity,
                    'component' => 'list',
                    'ad_url' => '/admin/'.$baseEntity.'/detail',
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionList'
                    ],
                    'filter_config' => [
                        [
                            'field' => 'id',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'ID',
                        ],
                    ],
                    'list_config' => [
                        [
                            'field' => 'id',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'ID'
                        ],
                        [
                            'field' => 'created_at',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Создан',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                    ]
                ]
            ],
            'detail' => [
                'menu' => [
                    'name' => 'ad_category_detail',
                    'label' => 'Категория',
                    'url' => '/admin/ad_category/detail',
                    'visible' => false,
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $detailTitle,
                    'entity' => $baseEntity,
                    'component' => 'detail',
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionView',
                    ],
                    'config' => function ($model) {
                        $stringService = ServiceManager::getInstance()->get(StringService::class);

                        return [
                            [
                                'field' => 'orderData',
                                'component' => DetailComponents::TEXTAREA_FIELD,
                                'label' => 'Данные заказа',
                                'value' => $model->orderData,
                            ],
                            [
                                'field' => 'total',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Итого',
                                'value' => $model->total,
                            ],
                            [
                                'field' => 'user_id',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Пользователь',
                                'value' => $model->user_id,
                            ],
                            [
                                'field' => 'created_at',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Дата создания',
                                'value' => $model->created_at,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];