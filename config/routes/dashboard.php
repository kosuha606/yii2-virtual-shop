<?php


use app\virtualModels\Admin\Domains\DateTime\DateTimeService;
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
            'orders_chart' => [
                'handler' => function() {
                    $result = [
                        'result' => true,
                    ];
                    $nowOffset = \Yii::$app->request->get('now_offset');

                    $dateTimeService = ServiceManager::getInstance()->get(DateTimeService::class);
                    $lastWeekRange = $dateTimeService->lastDaysRange('-14 day', 14, $nowOffset);
                    $ordersDynamic = \app\virtualModels\ServiceManager::getInstance()->orderService->buildOrdersStatistic($lastWeekRange);
                    $result['data'] = $ordersDynamic;

                    $response = new AdminResponseDTO(null, $result);
                    $response->json = $result;

                    return $response;
                }
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'sort' => -1,
                ],
                'handler' => function() {
                    Yii::$app->controller->getView()->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js@2.8.0');

                    $infoDto = ServiceManager::getInstance()->get(SearchService::class)->indexInfo();

                    $dateTimeService = ServiceManager::getInstance()->get(DateTimeService::class);
                    $lastWeekRange = $dateTimeService->lastDaysRange('-14 day', 14);
                    $ordersDynamic = \app\virtualModels\ServiceManager::getInstance()->orderService->buildOrdersStatistic($lastWeekRange);

                    return new AdminResponseDTO('<dashboard-page :props="_admin.config"></dashboard-page>', [
                        'config' => [
                            'articles_count' => ArticleVm::count([]),
                            'orders_count' => OrderVm::count([]),
                            'products_count' => ProductVm::count([]),
                            'search_index_count' => $infoDto->getNumbDocs(),
                            'orders_dynamic' => $ordersDynamic,
                        ],
                    ]);
                }
            ],
        ]
    ]
];
