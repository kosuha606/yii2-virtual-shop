<?php

namespace app\virtualModels\Admin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $id
 * @property $type
 * @property $value
 * @property $slug
 *
 */
class SeoFilterVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'type',
            'value',
            'slug',
        ];
    }
}