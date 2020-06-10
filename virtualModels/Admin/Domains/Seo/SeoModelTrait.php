<?php

namespace app\virtualModels\Admin\Domains\Seo;

use app\models\SeoUrl;

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
            'where' => [
                ['=', 'entity_id', $id],
                ['=', 'entity_class', $modelClass],
            ]
        ]);

        return $models ? $models[0] : SeoPageVm::create([]);
    }

    /**
     * @return SeoPageVm
     * @throws \Exception
     */
    public function getUrl()
    {
        $id = $this->id;
        $modelClass = get_class($this);
        $models = SeoUrlVm::many([
            'where' => [
                ['=', 'entity_id', $id],
                ['=', 'entity_class', $modelClass]
            ]
        ]);
        $model = $models ? $models[0] : SeoUrlVm::create([]);

        return $model->url;
    }
}