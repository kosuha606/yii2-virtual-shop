<?php

namespace app\virtualModels\Admin\Domains\Seo;

use app\models\SeoPage;

class SeoService
{
    /**
     * Получить SeoPageVm по урл адресу
     *
     * @param $url
     * @return SeoPageVm
     * @throws \Exception
     */
    public function findSeoPageByUrl($url)
    {
        $seoPage = SeoPageVm::one(['where' => [
            ['=', 'url', $url]
        ]]);

        if ($seoPage && $seoPage->id) {
            return $seoPage;
        }

        $seoUrl = SeoUrlVm::one([
            'where' => [
                ['=', 'url', $url]
            ]
        ]);

        $seoPage = SeoPageVm::one([
            'where' => [
                ['=', 'entity_id', $seoUrl->entity_id],
                ['=', 'entity_class', $seoUrl->entity_class],
            ]
        ]);

        if ($seoPage && $seoPage->id) {
            return $seoPage;
        }

        return SeoPageVm::create();
    }

    /**
     * Получить модель по url
     *
     * @param $url
     * @return bool
     * @throws \Exception
     */
    public function findModelByUrl($url)
    {
        $seoUrl = SeoUrlVm::one([
           'where' => [
               ['=', 'url', $url]
           ]
        ]);

        if (!$seoUrl) {
            return false;
        }

        $modelClass = $seoUrl->entity_class;

        if (!$modelClass) {
            return false;
        }

        $model = $modelClass::one([
            'where' => [
                ['=', 'id', $seoUrl->entity_id]
            ]
        ]);

        return $model;
    }

    /**
     * Генерация модели SeoUrlVm по модели сео
     *
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function generateUrlByModel(SeoModelInterface $model)
    {
        $url = $model->buildUrl();
        $id = $model->id;
        $modelClass = get_class($model);
        $this->removeUrlByModel($model);

        SeoUrlVm::create([
            'entity_id' => $id,
            'entity_class' => $modelClass,
            'url' => $url,
        ])->save();
    }

    /**
     * Удалить SeoUrlVm по связанной сео модели
     *
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function removeUrlByModel(SeoModelInterface $model)
    {
        $id = $model->id;
        $modelClass = get_class($model);

        /** @var SeoUrlVm[] $oldModels */
        $oldModels = SeoUrlVm::many([
            'where' => [
                ['=', 'entity_id', $id],
                ['=', 'entity_class', $modelClass],
            ]
        ]);

        // Удаляем все старые url модели этой сущности
        if ($oldModels) {
            foreach ($oldModels as $oldModel) {
                $oldModel->delete();
            }
        }
    }
}