<?php

namespace app\virtualModels\Admin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $id
 * @property $entity_id
 * @property $entity_class
 * @property $url
 * @property $created_at
 */
class SeoUrlVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'url',
            'created_at',
        ];
    }
}