<?php


use app\virtualModels\Admin\Domains\Search\SearchService;
use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use app\virtualModels\Admin\Domains\Seo\SeoService;
use app\virtualModels\Admin\Domains\Seo\SeoUrlVm;
use app\virtualModels\Admin\Dto\AdminResponseDTO;
use app\virtualModels\Admin\Services\AlertService;
use app\virtualModels\Domains\Article\Models\ArticleVm;
use app\virtualModels\Domains\Page\Models\PageVm;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'seo_url';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = SeoUrlVm::class;
$listTitle = 'Генерировать url';
$detailTitle = 'Генерировать url';

return [
    'routes' => [
        $baseEntity => [
            'regen' => [
                'handler' => function() {
                    $result = [
                        'result' => true
                    ];
                    $modelClasses = [
                        ProductVm::class,
                        ArticleVm::class,
                        PageVm::class,
                    ];
                    $seoService = ServiceManager::getInstance()->get(SeoService::class);

                    foreach ($modelClasses as $modelClass) {
                        $models = $modelClass::many(['where' => [['all']]]);

                        foreach ($models as $model) {
                            $seoService->generateUrlByModel($model);
                        }
                    }

                    Yii::$app->session->addFlash('success', 'Успешно сгенерированы url');

                    return new AdminResponseDTO('', $result);
                }
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'seo',
                ],
                'handler' => [
                    'type' => 'vue',
                    'h1' => $detailTitle,
                    'entity' => $baseEntity,
                    'component' => 'detail',
                    'detail_config' => [
                        'noback' => true,
                        'notabs' => true,
                        'nobuttons' => true,
                    ],
                    'crud' => [
                        'model' => $entityClass,
                        'action' => 'actionView',
                    ],
                    'config' => function ($model) {
                        $seoUrlsCnt = SeoUrlVm::count(['where' => [['all']]]);

                        return [
                            [
                                'field' => 'name',
                                'component' => 'GenurlsPage',
                                'label' => 'Название',
                                'props' => [
                                    'urlsCnt' => $seoUrlsCnt,
                                ]
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];
