<?php

use app\models\Design;
use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Domains\Design\Models\DesignVm;
use app\virtualModels\Domains\Design\Models\DesignWidgetVm;
use app\virtualModels\Domains\Design\Models\WidgetVm;
use app\virtualModels\Domains\Menu\Models\MenuItemVm;
use app\virtualModels\Domains\Page\Models\PageVm;
use app\virtualModels\Domains\Page\Models\SeoPageVm;
use app\virtualModels\Model\FilterCategoryVm;
use app\virtualModels\Model\OrderReserveVm;
use app\virtualModels\Model\ProductVm;
use app\virtualModels\Model\UserVm;
use app\virtualModels\Services\StringService;
use app\virtualModels\Admin\Structures\DetailComponents;
use app\virtualModels\Admin\Structures\ListComponents;
use kosuha606\VirtualModel\VirtualModel;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'page';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = PageVm::class;
$listTitle = 'Страницы';
$detailTitle = 'Страница';

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
                            'field' => 'title',
                            'component' => ListComponents::STRING_CELL,
                            'label' => 'Заголовок',
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

                    'additional_config' => function($model) {
                        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

                        $config = $secondaryService->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelField('page_id')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
                            ->setRelationClass(SeoPageVm::class)
                            ->setTabName('SEO')
                            ->setRelationEntities(SeoPageVm::many(['where' => [['=', 'page_id', $model->id]]]))
                            ->setConfig(function ($inModel) use ($model) {
                                $stringService = ServiceManager::getInstance()->get(StringService::class);
                                /** @var OrderReserveVm $inModel */
                                return [
                                    [
                                        'field' => 'page_id',
                                        'label' => 'Продукт',
                                        'component' => DetailComponents::HIDDEN_FIELD,
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
                            $config
                        ];
                    },
                    'config' => function ($model) {
                        $stringService = ServiceManager::getInstance()->get(StringService::class);

                        return [
                            [
                                'field' => 'title',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Заголовок',
                                'value' => $model->title,
                            ],
                            [
                                'field' => 'slug',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Ссылка',
                                'value' => $model->slug,
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