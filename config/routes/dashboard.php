<?php


use app\virtualModels\Admin\Domains\Search\SearchService;
use app\virtualModels\Admin\Dto\AdminResponseDTO;
use app\virtualModels\Domains\Article\Models\ArticleVm;
use app\virtualModels\Model\OrderVm;
use app\virtualModels\Model\ProductVm;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'dashboard';
$baseEntityCamel = Inflector::camelize($baseEntity);
$listTitle = 'Рабочий стол';
$detailTitle = 'Рабочий стол';

return [
    'routes' => [
        $baseEntity => [
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'sort' => -1,
                ],
                'handler' => function() {
                    $infoDto = ServiceManager::getInstance()->get(SearchService::class)->indexInfo();

                    return new AdminResponseDTO('<dashboard-page :props="_admin.config"></dashboard-page>', [
                        'config' => [
                            'articles_count' => ArticleVm::count([]),
                            'orders_count' => OrderVm::count([]),
                            'products_count' => ProductVm::count([]),
                            'search_index_count' => $infoDto->getNumbDocs(),
                        ],
                    ]);
                }
            ],
        ]
    ]
];
