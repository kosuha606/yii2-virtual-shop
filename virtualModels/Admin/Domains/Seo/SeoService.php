<?php

namespace app\virtualModels\Admin\Domains\Seo;

class SeoService
{
    /**
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
        $model = $modelClass::one([
            'where' => [
                ['=', 'id', $seoUrl->entity_id]
            ]
        ]);

        return $model;
    }

    /**
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