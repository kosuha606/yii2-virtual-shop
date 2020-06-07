<?php


use app\virtualModels\Admin\Domains\Settings\SettingsService;
use app\virtualModels\Admin\Domains\Settings\SettingsVm;
use app\virtualModels\Admin\Dto\AdminResponseDTO;
use app\virtualModels\Admin\Services\AlertService;
use kosuha606\VirtualModelHelppack\ServiceManager;
use yii\helpers\Inflector;

$baseEntity = 'settings';
$baseEntityCamel = Inflector::camelize($baseEntity);
$entityClass = SettingsVm::class;
$listTitle = 'Настройки';
$detailTitle = 'Настройки';

return [
    'routes' => [
        $baseEntity => [
            'save' => [
                'handler' => function() {
                    $settingsService = ServiceManager::getInstance()->get(SettingsService::class);
                    $data = Yii::$app->request->post('data', []);
                    $settingsService->saveSettings($data);
                    ServiceManager::getInstance()->get(AlertService::class)->success('Успешно сохранены настройки');

                    return new AdminResponseDTO('', [
                        'result' => true
                    ]);
                }
            ],
            'detail' => [
                'menu' => [
                    'name' => $baseEntity.'_detail',
                    'label' => $listTitle,
                    'url' => '/admin/'.$baseEntity.'/detail',
                    'parent' => 'system',
                ],
                'handler' => function() {
                    $settingsService = ServiceManager::getInstance()->get(SettingsService::class);
                    $settingsData = $settingsService->getSettings();

                    return new AdminResponseDTO('<settings-page :props="_admin.config"></settings-page>', [
                        'config' => [
                            'settingsData' => $settingsData
                        ],
                    ]);
                }
            ],
        ]
    ]
];
