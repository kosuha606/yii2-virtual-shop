<?php

namespace app\virtualModels\Admin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $entity_class
 * @property $title
 * @property $meta_keywords
 * @property $mata_description
 * @property $og_title
 * @property $og_description
 * @property $og_url
 * @property $og_image
 * @property $og_type
 * @property $canonical
 * @property $noindex
 *
 */
class SeoPageVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'title',
            'meta_keywords',
            'mata_description',
            'og_title',
            'og_description',
            'og_url',
            'og_image',
            'og_type',
            'canonical',
            'noindex',
        ];
    }
}