<?php

namespace app\virtual\Domains\AdminVersion;

use app\virtual\Domains\Framework\FrameworkVm;
use kosuha606\VirtualAdmin\Domains\Seo\SeoPageVm;
use kosuha606\VirtualAdmin\Form\SecondaryFormBuilder;
use kosuha606\VirtualAdmin\Form\SecondaryFormService;
use kosuha606\VirtualAdmin\Services\StringService;
use kosuha606\VirtualAdmin\Structures\DetailComponents;
use kosuha606\VirtualModel\VirtualModelEntity;
use kosuha606\VirtualModelHelppack\ServiceManager;

class AdminVersionService
{
    /**
     * @param $model
     * @return array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public static function FIELD($model)
    {
        $fieldJs = file_get_contents(__DIR__.'/_js/AdminVersionField.js');
        FrameworkVm::registerJs($fieldJs);

        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $config = $secondaryService->buildForm()
            ->setMasterModel($model)
            ->setMasterModelId($model->id.','.get_class($model))
            ->setMasterModelField('entity_id,entity_class')
            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
            ->setViewOnly(true)
            ->setRelationClass(AdminVersionVm::class)
            ->setTabName('Версии')
            ->setRelationEntities(SeoPageVm::many(['where' => [
                ['=', 'entity_id', $model->id],
                ['=', 'entity_class', get_class($model)]
            ]]))
            ->setConfig(function ($inModel) use ($model) {
                $stringService = ServiceManager::getInstance()->get(StringService::class);
                $adminModels = VirtualModelEntity::allToArray(AdminVersionVm::many([
                    'where' => [
                        ['=', 'entity_id', $model->id],
                        ['=', 'entity_class', get_class($model)]
                    ],
                    'orderBy' => ['created_at' => SORT_DESC],
                    'offset' => 1,
                ]));

                return [
                    [
                        'field' => 'entity_id',
                        'label' => 'Список версий для восстановления',
                        'component' => 'AdminVersionField',
                        'value' => $inModel->entity_id,
                        'props' => [
                            'maxVersions' => AdminVersionObserver::MAX_VERSIONS_COUNT,
                            'versions' => $adminModels
                        ]
                    ],
                ];
            })
            ->getConfig()
        ;

        return $config;
    }
}