<?php

namespace app\virtualModels\Admin\Domains\Seo;

class SeoUrlObserver
{
    /**
     * После сохранения основной модели необходимо
     * сохранить сгенерированную ссылку для модели
     *
     * @param SeoModelInterface $model
     * @throws \Exception
     */
    public function afterSave(SeoModelInterface $model)
    {
        $url = $model->buildUrl();
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
    public function afterDelete(SeoModelInterface $model)
    {
        $id = $model->id;
        $modelClass = get_class($model);

        /** @var SeoUrlVm[] $oldModels */
        $oldModels = SeoUrlVm::many([
            'entity_id' => $id,
            'entity_class' => $modelClass,
        ]);

        // Удаляем все старые url модели этой сущности
        if ($oldModels) {
            foreach ($oldModels as $oldModel) {
                $oldModel->delete();
            }
        }
    }
}