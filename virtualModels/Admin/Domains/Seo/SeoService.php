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
}