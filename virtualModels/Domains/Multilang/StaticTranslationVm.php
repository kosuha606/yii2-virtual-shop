<?php

namespace app\virtualModels\Domains\Multilang;

use kosuha606\VirtualModel\VirtualModel;

class StaticTranslationVm extends VirtualModel
{
    use MultilangTrait;

    public function attributes(): array
    {
        return [
            'id',
            'value',
        ];
    }
}