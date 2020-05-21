<?php

use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Model\OrderVm;
use app\virtualModels\Model\ProductRestsVm;
use app\virtualModels\Model\ProductSeoVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\UserVm;
use app\virtualModels\Services\StringService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Structures\ListComponents;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'product';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = ProductVm::class;
$listTitle = 'Продукты';
$detailTitle = 'Продукт';

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
                            case 'name':
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
                            'field' => 'name',
                            'component' => DetailComponents::INPUT_FIELD,
                            'label' => 'Название',
                        ],
                    ],
                    'list_config' => [
                        [
                            'field' => 'id',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'ID'
                        ],
                        [
                            'field' => 'name',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Название',
                            'props' => [
                                'link' => 1,
                            ]
                        ],
                        [
                            'field' => 'price',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Цена'
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
                    'additional_config' => function($model) {
                        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

                        $config = $secondaryService->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelField('productId')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_MANY)
                            ->setRelationClass(ProductRestsVm::class)
                            ->setTabName('Остатки')
                            ->setRelationEntities(ProductRestsVm::many(['where' => [['=', 'productId', $model->id]]]))
                            ->setConfig(function ($inModel) use ($model) {
                                return [
                                    [
                                        'field' => 'productId',
                                        'label' => 'Продукт',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $model->id,
                                    ],
                                    [
                                        'field' => 'qty',
                                        'label' => 'Кол-во',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->qty,
                                    ],
                                    [
                                        'field' => 'userType',
                                        'label' => 'Тип пользователя',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->userType,
                                    ],
                                ];
                            })
                            ->getConfig()
                        ;

                        $configSeo = $secondaryService
                            ->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelField('product_id')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
                            ->setRelationClass(ProductSeoVm::class)
                            ->setTabName('SEO')
                            ->setRelationEntities(ProductSeoVm::many(['where' => [['=', 'product_id', $model->id]]]))
                            ->setConfig(function ($inModel) use ($model) {
                                return [
                                    [
                                        'field' => 'product_id',
                                        'label' => 'Продукт',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $model->id,
                                    ],
                                    [
                                        'field' => 'meta_title',
                                        'label' => 'Мета заголовок',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->meta_title,
                                    ],
                                    [
                                        'field' => 'meta_keywords',
                                        'label' => 'Мета ключевые слова',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->meta_keywords,
                                    ],
                                    [
                                        'field' => 'meta_description',
                                        'label' => 'Мета описание',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->meta_description,
                                    ],
                                ];
                            })
                            ->getConfig()
                        ;

                        return [
                            $config,
                            $configSeo
                        ];
                    },
                    'config' => function ($model) {
                        $stringService = ServiceManager::getInstance()->get(StringService::class);

                        return [
                            [
                                'field' => 'name',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Название',
                                'value' => $model->name,
                            ],
                            [
                                'field' => 'price',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Цена',
                                'value' => $model->price,
                            ],
                            [
                                'field' => 'price2B',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Цена оптом',
                                'value' => $model->price2B,
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];