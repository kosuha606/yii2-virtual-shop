<?php


use app\virtualModels\Admin\Domains\Search\SearchService;
use app\virtualModels\Admin\Domains\Search\SearchVm;
use app\virtualModels\Admin\Dto\AdminResponseDTO;
use app\virtualModels\Admin\Services\AlertService;
use app\virtualModels\Admin\Structures\DetailComponents;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'search';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = SearchVm::class;
$listTitle = 'Поиск';
$detailTitle = 'Поиск';

return [
    'routes' => [
        $baseEntity => [
            'reindex' => [
                'handler' => function() {
                    $result = [];
                    ServiceManager::getInstance()->get(AlertService::class)->success('Поиск переиндексирован');
                    ServiceManager::getInstance()->get(SearchService::class)->reindexAll();

                    return new AdminResponseDTO('', $result);
                },
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'system',
                    'sort' => 99,
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
                        $infoDto = ServiceManager::getInstance()->get(SearchService::class)->indexInfo();
                        $k = 1;

                        return [
                            [
                                'field' => 'name',
                                'component' => 'SearchPage',
                                'label' => 'Название',
                                'props' => [
                                    'numDocs' => $infoDto->getNumbDocs()
                                ]
                            ],
                        ];
                    },
                ]
            ],
        ]
    ]
];