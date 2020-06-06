<?php

namespace app\virtualModels\Admin\Domains\Seo;

use kosuha606\VirtualModel\VirtualModel;

/**
 *
 * @property $id
 * @property $from_url
 * @property $to_url
 *
 */
class SeoRedirectVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'from_url',
            'to_url',
        ];
    }
}