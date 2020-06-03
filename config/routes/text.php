<?php

use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Domains\Article\Models\ArticleVm;
use app\virtualModels\Domains\Article\Models\SeoArticleVm;
use app\virtualModels\Domains\Text\Models\TextVm;
use app\virtualModels\Model\OrderReserveVm;
use app\virtualModels\Services\StringService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Structures\ListComponents;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'text';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = TextVm::class;
$listTitle = 'Тексты';
$detailTitle = 'Текст';

return [
    'routes' => [
        $baseEntity => [
            'list' => [
                'menu' => [
                    'name' => $baseEntity.'_list',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/list',
                    'parent' => 'content',
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
                            'field' => 'description',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Описание',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'code',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Код',
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
                                'field' => 'description',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Описание',
                                'value' => $model->description,
                            ],
                            [
                                'field' => 'code',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Код',
                                'value' => $model->code,
                            ],
                            [
                                'field' => 'content',
                                'component' => DetailComponents::REDACTOR_FIELD,
                                'label' => 'Содержимое',
                                'value' => $model->content,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];