<?php

use app\virtualModels\Model\ActionVm;
use app\virtualModels\Model\DeliveryVm;
use app\virtualModels\Model\OrderVm;
use app\virtualModels\Model\PaymentVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\UserVm;
use app\virtualModels\Services\StringService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Structures\ListComponents;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'payment';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = PaymentVm::class;
$listTitle = 'Оплата';
$detailTitle = 'Оплата';

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
                    'filter' => function($filterKey) {
                        $function = '=';
                        switch ($filterKey) {
                            case 'description':
                                $function = 'like';
                                break;
                        }

                        return $function;
                    },
                    'filter_config' => [
                        [
                            'field' => 'id',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'ID',
                        ],
                        [
                            'field' => 'description',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'Описание',
                        ],
                    ],
                    'list_config' => [
                        [
                            'field' => 'id',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'ID'
                        ],
                        [
                            'field' => 'description',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Описание',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'comission',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Комиссия'
                        ],
                        [
                            'field' => 'created_at',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Создан'
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
                                'field' => 'comission',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Комиссия',
                                'value' => $model->comission,
                            ],
                            [
                                'field' => 'description',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Описание',
                                'value' => $model->description,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];