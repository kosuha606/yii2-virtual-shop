<?php

namespace app\virtualModels\Domains\Cache;

use kosuha606\VirtualModel\VirtualModel;

class TranslationVm extends VirtualModel
{
    public function attributes(): array
    {
        return [
            'id',
            'entity_id',
            'entity_class',
            'lang_id',
            'attribute',
            'data',
        ];
    }
}