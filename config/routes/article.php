<?php

use app\models\Design;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use app\virtualModels\Admin\Domains\Version\VersionVm;
use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Domains\Article\Models\ArticleVm;
use app\virtualModels\Domains\Article\Models\SeoArticleVm;
use app\virtualModels\Domains\Comment\Models\CommentVm;
use app\virtualModels\Domains\Design\Models\DesignVm;
use app\virtualModels\Domains\Design\Models\DesignWidgetVm;
use app\virtualModels\Domains\Design\Models\WidgetVm;
use app\virtualModels\Domains\Menu\Models\MenuItemVm;
use app\virtualModels\Domains\Page\Models\PageVm;
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

$baseEntity = 'article';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = ArticleVm::class;
$listTitle = 'Статья';
$detailTitle = 'Статья';

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
                        'orderBy' => [
                            'field' => 'id',
                            'direction' => 'desc',
                        ],
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
                            ->setMasterModelId($model->id.','.get_class($model))
                            ->setMasterModelField('entity_id,entity_class')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
                            ->setRelationClass(\app\virtualModels\Admin\Domains\Seo\SeoPageVm::class)
                            ->setTabName('SEO_data')
                            ->setRelationEntities(SeoPageVm::many(['where' => [
                                ['=', 'entity_id', $model->id],
                                ['=', 'entity_class', get_class($model)]
                            ]]))
                            ->setConfig(function ($inModel) use ($model) {
                                $stringService = ServiceManager::getInstance()->get(StringService::class);
                                /** @var OrderReserveVm $inModel */
                                return [
                                    [
                                        'field' => 'id',
                                        'label' => '',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => $inModel->id,
                                    ],
                                    [
                                        'field' => 'entity_id',
                                        'label' => '',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => $model->id,
                                    ],
                                    [
                                        'field' => 'entity_class',
                                        'label' => '',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => get_class($model),
                                    ],
                                    [
                                        'field' => 'title',
                                        'label' => 'Заголовок',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->title,
                                    ],
                                    [
                                        'field' => 'meta_keywords',
                                        'label' => 'Мета ключевые слова',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->meta_keywords,
                                    ],
                                    [
                                        'field' => 'mata_description',
                                        'label' => 'Мета описание',
                                        'component' => DetailComponents::TEXTAREA_FIELD,
                                        'value' => $inModel->mata_description,
                                    ],
                                    [
                                        'field' => 'og_title',
                                        'label' => 'OG заголовок',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->og_title,
                                    ],
                                    [
                                        'field' => 'og_description',
                                        'label' => 'OG описание',
                                        'component' => DetailComponents::TEXTAREA_FIELD,
                                        'value' => $inModel->og_description,
                                    ],
                                    [
                                        'field' => 'og_url',
                                        'label' => 'OG адресс',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->og_url,
                                    ],
                                    [
                                        'field' => 'og_image',
                                        'label' => 'OG изображение',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->og_image,
                                    ],
                                    [
                                        'field' => 'og_type',
                                        'label' => 'OG тип',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->og_type,
                                    ],
                                    [
                                        'field' => 'canonical',
                                        'label' => 'Canonical',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->canonical,
                                    ],
                                    [
                                        'field' => 'noindex',
                                        'label' => 'Noindex',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->noindex,
                                    ],
                                    [
                                        'field' => 'sitemap_importance',
                                        'label' => 'Sitemap приоритет',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->sitemap_importance,
                                    ],
                                    [
                                        'field' => 'sitemap_freq',
                                        'label' => 'Sitemap частота обновления',
                                        'component' => DetailComponents::INPUT_FIELD,
                                        'value' => $inModel->sitemap_freq,
                                    ],
                                ];
                            })
                            ->getConfig()
                        ;

                        $configComment = $secondaryService
                            ->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelId($model->id.','.get_class($model))
                            ->setMasterModelField('model_id,model_class')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_MANY)
                            ->setRelationClass(CommentVm::class)
                            ->setTabName('Комментарии')
                            ->setRelationEntities(CommentVm::many(['where' => [
                                ['=', 'model_id', $model->id],
                                ['=', 'model_class', get_class($model)],
                            ]]))
                            ->setConfig(function ($inModel) use ($model) {
                                $stringService = ServiceManager::getInstance()->get(StringService::class);

                                return [
                                    [
                                        'field' => 'model_id',
                                        'label' => 'Продукт',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => $model->id,
                                    ],
                                    [
                                        'field' => 'model_class',
                                        'label' => 'Продукт',
                                        'component' => DetailComponents::HIDDEN_FIELD,
                                        'value' => get_class($model),
                                    ],
                                    [
                                        'field' => 'user_id',
                                        'label' => 'Пользователь',
                                        'component' => DetailComponents::SELECT_FIELD,
                                        'value' => $inModel->user_id,
                                        'props' => [
                                            'items' => $stringService->map(VirtualModel::allToArray(UserVm::many(['where' => [['all']]])), 'id', 'email')
                                        ]
                                    ],
                                    [
                                        'field' => 'content',
                                        'label' => 'Сообщение',
                                        'component' => DetailComponents::TEXTAREA_FIELD,
                                        'value' => $inModel->content,
                                    ],
                                ];
                            })
                            ->getConfig()
                        ;

                        $configVersion = $secondaryService
                            ->buildForm()
                            ->setMasterModel($model)
                            ->setMasterModelId($model->id.','.get_class($model))
                            ->setMasterModelField('entity_id,entity_class')
                            ->setRelationType(SecondaryFormBuilder::ONE_TO_MANY)
                            ->setRelationClass(VersionVm::class)
                            ->setViewOnly(true)
                            ->setTabName('Версии')
                            ->setRelationEntities(VersionVm::many(['where' => [
                                ['=', 'entity_id', $model->id],
                                ['=', 'entity_class', get_class($model)],
                            ]]))
                            ->setConfig(function ($inModel) use ($model) {
                                return [
                                    [
                                        'field' => 'created_at',
                                        'label' => 'Версия от',
                                        'component' => DetailComponents::VERSION_FIELD,
                                        'value' => $inModel->created_at,
                                        'props' => [
                                            'id' => $inModel->id,
                                        ]
                                    ],
                                ];
                            })
                            ->getConfig()
                        ;

                        return [
                            $config,
                            $configComment,
                            $configVersion,
                        ];
                    },
                    'config' => function ($model) {
                        $stringService = ServiceManager::getInstance()->get(StringService::class);

                        return [
                            DetailComponents::MULTILANG_FIELD(
                                DetailComponents::INPUT_FIELD,
                                'title',
                                'Заголовок',
                                $model->title,
                                $model
                            ),
                            [
                                'field' => 'photo',
                                'component' => DetailComponents::IMAGE_FIELD,
                                'label' => 'Изображение',
                                'value' => $model->photo,
                            ],
                            [
                                'field' => 'slug',
                                'component' => DetailComponents::INPUT_FIELD,
                                'label' => 'Ссылка',
                                'value' => $model->slug,
                            ],
                            DetailComponents::MULTILANG_FIELD(
                                DetailComponents::REDACTOR_FIELD,
                                'content',
                                'Содержимое',
                                $model->content,
                                $model
                            ),
                        ];
                    },
                ]
            ],
        ]
    ]
];