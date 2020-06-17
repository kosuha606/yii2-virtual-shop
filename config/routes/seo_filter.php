<?php

use app\virtualModels\Admin\Domains\Seo\SeoFilterVm;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use app\virtualModels\Admin\Domains\Seo\SeoRedirectVm;
use app\virtualModels\Model\FilterCategoryVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\UserVm;
use app\virtualModels\Services\StringService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Structures\ListComponents;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'seo_filter';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = SeoFilterVm::class;
$listTitle = 'SEO фильтры';
$detailTitle = 'SEO фильтр';

return [
    'routes' => [
        $baseEntity => [
            'list' => [
                'menu' => [
                    'name' => $baseEntity.'_list',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/list',
                    'parent' => 'seo',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $listTitle,
                    'entity' => $baseEntity,
                    'component' => 'list',
                    'ad_url' => '/admin/'.$baseEntity.'/detail',
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionList',
                        'orderBy' => [
                            'field' => 'id',
                            'direction' => 'desc',
                        ],
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
                            'field' => 'value',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Значение',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'type',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Тип',
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
                                'field' => 'value',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Значение',
                                'value' => $model->value,
                            ],
                            [
                                'field' => 'slug',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Ссылка',
                                'value' => $model->slug,
                            ],
                            [
                                'field' => 'type',
                                'component' => DetailComponents::SELECT_FIELD,
                                'label' => 'Тип',
                                'value' => $model->type,
                                'props' => [
                                    'items' => $stringService->map(VirtualModel::allToArray(FilterCategoryVm::many(['where' => [['all']]])), 'id', 'name')
                                ]
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];