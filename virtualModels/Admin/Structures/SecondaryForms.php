<?php

namespace app\virtualModels\Admin\Structures;

use app\virtualModels\Admin\Domains\Seo\SeoPageVm;
use app\virtualModels\Admin\Form\SecondaryFormBuilder;
use app\virtualModels\Admin\Form\SecondaryFormService;
use app\virtualModels\Model\OrderReserveVm;
use app\virtualModels\Services\StringService;
use kosuha606\VirtualModelHelppack\ServiceManager;

class SecondaryForms
{
    /**
     * @param $inModel
     * @return array
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     * @throws \Exception
     */
    public static function SEO_PAGE($model)
    {
        $secondaryService = ServiceManager::getInstance()->get(SecondaryFormService::class);

        $configSeo = $secondaryService->buildForm()
            ->setMasterModel($model)
            ->setMasterModelId($model->id.','.get_class($model))
            ->setMasterModelField('entity_id,entity_class')
            ->setRelationType(SecondaryFormBuilder::ONE_TO_ONE)
            ->setRelationClass(SeoPageVm::class)
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

        return $configSeo;
    }
}