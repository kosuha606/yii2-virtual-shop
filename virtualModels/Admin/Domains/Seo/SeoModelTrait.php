<?php

namespace app\virtualModels\Admin\Domains\Seo;

trait SeoModelTrait
{
    /**
     * @return SeoPageVm
     * @throws \Exception
     */
    public function getSeo(): SeoPageVm
    {
        $id = $this->id;
        $modelClass = get_class($this);
        $models = SeoPageVm::many([
            'entity_id' => $id,
            'entity_class' => $modelClass,
        ]);

        return $models ? $models[0] : SeoPageVm::create([]);
    }
}