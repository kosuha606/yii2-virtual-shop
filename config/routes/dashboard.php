<?php


use kosuha606\VirtualAdmin\Domains\DateTime\DateTimeService;
use kosuha606\VirtualAdmin\Domains\Search\SearchService;
use kosuha606\VirtualAdmin\Dto\AdminResponseDTO;
use kosuha606\VirtualModelHelppack\ServiceManager;
use kosuha606\VirtualShop\Model\OrderVm;
use kosuha606\VirtualShop\Model\ProductVm;
use kosuha606\VirtualContent\Domains\Article\Models\ArticleVm;
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
                    $ordersDynamic = \kosuha606\VirtualShop\ServiceManager::getInstance()->orderService->buildOrdersStatistic($lastWeekRange);
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
                    $ordersDynamic = \kosuha606\VirtualShop\ServiceManager::getInstance()->orderService->buildOrdersStatistic($lastWeekRange);

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
